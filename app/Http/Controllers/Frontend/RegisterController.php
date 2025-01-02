<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PasswordChangeRegisterRequest;
use App\Http\Requests\Frontend\ProfileImageRegisterRequest;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Http\Requests\Frontend\UpdateRegisterRequest;
use App\Models\Access\User\User;
use App\Models\BusinessProfile;
use App\Models\City;
use App\Models\County;
use App\Models\Industry;
use App\Models\Service;
use App\Models\State;
use App\Models\SubscribeServices;
use App\Models\UserInterest;
use App\Models\UserProfile;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Class LanguageController.
 */
class RegisterController extends Controller
{
    public function profile()
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::id())->with('user_profile', 'business_profile')->first();

            return view('frontend.userRegister.profile_view', compact('user'));
        }

        return redirect()->route('frontend.auth.login')->with('flash_warning', 'Please login to view your profile');
    }

    public function userCreate(Request $request)
    {
        $user = false;
        $state = false;
        if ($request->time && $request->code) {

            $user = User::where('confirmation_code', $request->code)->where('created_at', $request->time)->with('user_profile', 'business_profile')->first();
            if (! empty($user->state_id)) {
                $state = State::where('id', $user->state_id)->pluck('state')->first();
            }
            if ($user) {
                return view('frontend.userRegister.userCreate', compact('user', 'state'));
            } else {

                return redirect()->route('frontend.auth.login')->with('flash_danger', 'Invalid URL.');
            }
        } else {
            return view('frontend.userRegister.userCreate', compact('user', 'state'));
        }
    }

    public function businessCreate(Request $request)
    {
        $industries = Industry::whereHas('services')->get();

        $business = false;
        if ($request->time && $request->code) {

            $business = User::where('confirmation_code', $request->code)->where('created_at', $request->time)->first();
            if ($business) {
                return view('frontend.userRegister.businessCreate', compact('business', 'industries'));
            } else {

                return redirect()->route('frontend.auth.login')->with('flash_danger', 'Invalid URL.');
            }
        } else {

            return view('frontend.userRegister.businessCreate', compact('industries'));
        }
    }

    public function businessServices(Request $request): Response
    {
        $services = Service::where('industry_id', $request->industry_id)->pluck('service', 'id');

        return response(['success' => true, 'services' => $services]);
    }

    public function userstore(RegisterRequest $request): RedirectResponse
    {

        $data = $request->all();

        // update new signer User
        if (isset($data['savedTime'])) {
            $existingUser = User::where('email', $data['email'])->where('created_at', $data['savedTime'])->with('user_profile', 'business_profile')->first();
            if ($existingUser) {

                $this->_updateExistingUser($existingUser, $data);

                return redirect()->route('frontend.index')->with('flash_success', 'User profile successfully updated.');
            }
        }

        if ($data['user_type'] == config('constant.user_type.2') || $data['user_type'] == config('constant.user_type.3')) {

            $checkState = $this->_checkState($data);   //find if state exists or not
            if (! $checkState) {
                return redirect()->back()->with('flash_danger', 'State not found.');
            }
            $user = new User;
            $user->email = strtolower($data['email']);
            $user->password = Hash::make($data['password']);
            $user->confirmation_code = md5(uniqid(mt_rand(), true));
            $user->state_id = $checkState->id;
            $user->county = $data['county'];
            $user->city = $data['city'];
            $user->zip_code = $data['zip_code'];
            $user->phone_no = $data['phone_no'];
            $user->longitude = $data['longitude'];
            $user->latitude = $data['latitude'];
            $user->confirmed = config('access.users.confirm_email') ? 0 : 1;

            if ($user->save()) {

                $userProfile = new UserProfile;
                if ($data['user_type'] == config('constant.user_type.3')) {

                    //                    $fullName = implode(' ', $request->full_name);

                    $userProfile->user_id = $user->id;
                    $userProfile->full_name = $data['name'];
                    $userProfile->address = $data['address'];
                    $userProfile->share_profile = config('constant.inverse_share_profile.'.$data['share_profile']);
                    $userProfile->loan_status = config('constant.inverse_loan_status.'.$data['loan_status']);
                    $userProfile->first_name = $data['first_name'];
                    $userProfile->middle_name = $data['middle_name'];
                    $userProfile->last_name = $data['last_name'];
                    $userProfile->electronic_signature = $data['electronic_signature'];
                    //                    $user->secure_code = $data['phone_no'];
                    if ($userProfile->save()) {

                        $user->attachRole(config('constant.inverse_user_type.User'));   //assign user role

                        foreach ($data['interest'] as $interest) {
                            $userInterest = new UserInterest;

                            $userInterest->user_profile_id = $userProfile->id;
                            $userInterest->interest_type = config('constant.inverse_interests.'.$interest);
                            $userInterest->save();

                        }
                        $user->notify(new UserNeedsConfirmation($user->confirmation_code, $userProfile->first_name.' '.$userProfile->last_name));

                        return redirect()->route('frontend.index')->with('flash_success', 'Your account was successfully created. We have sent you an e-mail to confirm your account.');
                    }
                }

                if ($data['user_type'] == config('constant.user_type.2')) {
                    $businessProfile = new BusinessProfile;
                    $businessProfile->user_id = $user->id;
                    $businessProfile->company_name = $data['company_name'];
                    $businessProfile->company_address = $data['company_address'];
                    $businessProfile->company_website = $data['company_website'];
                    $businessProfile->industry_id = $data['industry'];
                    $businessProfile->area_of_service = config('constant.inverse_area_of_service.'.$data['area_of_service']);

                    if ($businessProfile->save()) {

                        $user->attachRole(config('constant.inverse_user_type.Business'));   //assign business role

                        if ($data['services']) {
                            foreach ($data['services'] as $service) {
                                $subscribeServices = new SubscribeServices;
                                $subscribeServices->service_id = $service;
                                $subscribeServices->user_id = $user->id;
                                $subscribeServices->save();
                            }
                        }

                        $user->notify(new UserNeedsConfirmation($user->confirmation_code, $businessProfile->company_name));

                        return redirect()->route('frontend.index')->with('flash_success', 'Your account was successfully created. We have sent you an e-mail to confirm your account.');
                    }
                }
            } else {

                return redirect()->back()->with('flash_danger', 'Profile not saved.');
            }
        }

        return redirect()->back()->with('flash_danger', 'Invalid User Data.');
    }

    private function _checkState($data)
    {
        $checkState = State::where('state', $data['state'])->first();

        return $checkState;
    }

    private function _updateExistingUser($existingUser, $data)
    {
        $getlanlord = \App\Models\LandlordQuestionnaire::where('partners', $existingUser->id)->get();

        $gettenant = \App\Models\TenantQuestionnaire::where('partners', $existingUser->id)->get();
        $checkState = $this->_checkState($data);   //find if state exists or not
        $input['password'] = Hash::make($data['password']);
        $input['state_id'] = $checkState->id;
        $input['confirmation_code'] = $data['code'];
        $input['county'] = $data['county'];
        $input['city'] = $data['city'];
        $input['phone_no'] = $data['phone_no'];
        $input['zip_code'] = $data['zip_code'];
        if (isset($data['longitude']) && $data['longitude']) {
            $input['longitude'] = $data['longitude'];
        }
        if (isset($data['latitude']) && $data['latitude']) {
            $input['latitude'] = $data['latitude'];
        }
        $input['status'] = 1;
        $input['confirmed'] = 1;

        if (User::where('email', $data['email'])->where('created_at', $data['savedTime'])->update($input)) {
            if (! empty($gettenant)) {
                foreach ($gettenant as $tenant) {
                    if (\App\Models\RentSignature::where('offer_id', $tenant->rent_offer_id)->first()) {
                        $rentSignature['state_id'] = $checkState->id;
                        $rentSignature['county'] = $data['county'];
                        $rentSignature['city'] = $data['city'];
                        $rentSignature['phone_no'] = $data['phone_no'];
                        $rentSignature['zip_code'] = $data['zip_code'];
                        $rentSignature['address'] = $data['address'];
                        \App\Models\RentSignature::where('offer_id', $tenant->rent_offer_id)->where('user_id', $existingUser->id)->update($rentSignature);
                        //                    die('dfadf');
                    }
                }
            }
            if (! empty($getlanlord)) {
                foreach ($getlanlord as $landlord) {
                    if (\App\Models\RentSignature::where('offer_id', $landlord->offer_id)->first()) {
                        $rentSignature['state_id'] = $checkState->id;
                        $rentSignature['county'] = $data['county'];
                        $rentSignature['city'] = $data['city'];
                        $rentSignature['phone_no'] = $data['phone_no'];
                        $rentSignature['zip_code'] = $data['zip_code'];
                        $rentSignature['address'] = $data['address'];
                        \App\Models\RentSignature::where('offer_id', $landlord->offer_id)->where('user_id', $existingUser->id)->update($rentSignature);
                    }
                }
            }

            if (in_array(config('constant.inverse_user_type.User'), array_column($existingUser->roles->toArray(), 'id'))) {
                //                $userProfile = new UserProfile();
                $userProfile['user_id'] = $existingUser->id;
                $userProfile['full_name'] = $data['name'];
                $userProfile['address'] = $data['address'];
                $userProfile['share_profile'] = config('constant.inverse_share_profile.'.$data['share_profile']);
                $userProfile['loan_status'] = config('constant.inverse_loan_status.'.$data['loan_status']);
                $userProfile['first_name'] = $data['first_name'];
                $userProfile['middle_name'] = $data['middle_name'];
                $userProfile['last_name'] = $data['last_name'];
                $userProfile['electronic_signature'] = $data['electronic_signature'];

                //check userProfile exist and get that id
                UserProfile::where('user_id', $existingUser->id)->update($userProfile);
                $getUserProfileId = UserProfile::where('user_id', $existingUser->id)->first();
                if ($getUserProfileId) {
                    foreach ($data['interest'] as $interest) {
                        $userInterest = new UserInterest;
                        $userInterest->user_profile_id = $getUserProfileId->id;
                        $userInterest->interest_type = config('constant.inverse_interests.'.$interest);
                        $userInterest->save();
                    }
                }
            } elseif (in_array(config('constant.inverse_user_type.Business'), array_column($existingUser->roles->toArray(), 'id'))) {
                $businessProfile = new BusinessProfile;
                $businessProfile->user_id = $existingUser->id;
                $businessProfile->company_name = $data['company_name'];
                $businessProfile->company_address = $data['company_address'];
                $businessProfile->company_website = $data['company_website'];
                $businessProfile->industry_id = $data['industry'];
                $businessProfile->area_of_service = config('constant.inverse_area_of_service.'.$data['area_of_service']);
                $businessProfile->save();
                if ($data['services']) {
                    foreach ($data['services'] as $service) {
                        SubscribeServices::where('user_id', Auth::id())->where('service_id', $service)->forcedelete();
                        $subscribeServices = new SubscribeServices;
                        $subscribeServices->service_id = $service;
                        $subscribeServices->user_id = Auth::id();
                        $subscribeServices->save();
                    }
                }
            }
        }
    }

    public function profileEdit($id): View
    {
        $user = User::where('id', Auth::id())->with(['user_profile' => function ($q) {
            $q->with('user_interests');
        }])->with(['business_profile', 'subscribeServices'])->first();
        $state = State::where('id', $user->state_id)->first();
        $city = City::where('id', $user->city)->first();
        $counties = County::where('state_id', $user->state_id)->orderBy('county')->get();
        $allIndustries = Industry::get();
        if ($user->business_profile || in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id'))) {
            if ($user->business_profile) {
                $industry = Industry::where('id', $user->business_profile->industry_id)->whereHas('services')->with('services')->first();
            } else {
                $industry = null;
            }

        } else {
            $industry = null;
        }

        return view('frontend.user.profile_edit')->with(compact('user', 'state', 'allIndustries', 'industry', 'counties', 'city'));
    }

    public function profileUpdate(UpdateRegisterRequest $request)
    {
        $data = $request->all();
        $checkState = State::where('state', $data['state'])->first();
        if (! $checkState) {
            return redirect()->back()->with('flash_danger', 'State not found.');
        }
        if ($data['password'] && $data['password_confirmation']) {
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ]);
            $input['password'] = Hash::make($data['password']);
        }
        $input['state_id'] = $checkState['id'];
        $input['zip_code'] = $data['zip_code'];
        $input['county'] = $data['county'];
        $input['city'] = $data['city'];
        $input['phone_no'] = $data['phone_no'];
        if (isset($data['longitude']) && $data['longitude']) {
            $input['longitude'] = $data['longitude'];
        }
        if (isset($data['latitude']) && $data['latitude']) {
            $input['latitude'] = $data['latitude'];
        }
        if (User::where('id', Auth::id())->update($input)) {
            if ($data['user_type'] == config('constant.user_type.3')) {
                $loggedInUser = User::where('id', Auth::id())->with('user_profile')->first();
                if (! $loggedInUser->user_profile) {
                    $this->_createUser($request->all());
                } else {
                    $userInput['full_name'] = $data['name'];
                    $userInput['address'] = $data['address'];
                    $userInput['share_profile'] = config('constant.inverse_share_profile.'.$data['share_profile']);
                    $userInput['loan_status'] = config('constant.inverse_loan_status.'.$data['loan_status']);
                    $userInput['first_name'] = $data['first_name'];
                    $userInput['middle_name'] = $data['middle_name'];
                    $userInput['last_name'] = $data['last_name'];
                    $userInput['electronic_signature'] = $data['electronic_signature'];
                    UserProfile::where('id', $loggedInUser->user_profile->id)->update($userInput);
                }
                $loggedInUser = User::where('id', Auth::id())->with('user_profile')->first();
                UserInterest::where('user_profile_id', $loggedInUser->user_profile->id)->forcedelete();
                foreach ($data['interest'] as $interest) {
                    $userInterest = new UserInterest;
                    $userInterest->user_profile_id = $loggedInUser->user_profile->id;
                    $userInterest->interest_type = config('constant.inverse_interests.'.$interest);
                    $userInterest->save();
                }

                return redirect()->route('frontend.user.dashboard')->with('flash_success', 'User updated successfully.');
            } elseif ($data['user_type'] == config('constant.user_type.2')) {

                $loggedInUser = User::where('id', Auth::id())->with('business_profile')->first();
                if (! $loggedInUser->business_profile) {
                    $this->_createBusinessUser($request->all());
                } else {
                    $businessInput['company_name'] = $data['company_name'];
                    $businessInput['company_address'] = $data['company_address'];
                    $businessInput['company_website'] = $data['company_website'];
                    $businessInput['industry_id'] = $data['industry'];
                    $businessInput['area_of_service'] = $data['area_of_service'];

                    BusinessProfile::where('id', $loggedInUser->business_profile->id)->update($businessInput);
                }
                if ($data['services']) {
                    foreach ($data['services'] as $service) {
                        SubscribeServices::where('user_id', Auth::id())->where('service_id', $service)->forcedelete();
                        $subscribeServices = new SubscribeServices;
                        $subscribeServices->service_id = $service;
                        $subscribeServices->user_id = Auth::id();
                        $subscribeServices->save();
                    }
                }

                return redirect()->route('frontend.user.dashboard')->with('flash_success', 'User updated successfully.');
            }
        }

        return view('frontend.user.profile_edit', ['user' => Auth::user()]);
    }

    private function _createBusinessUser($data)
    {
        $businessProfile = new BusinessProfile;
        $businessProfile->user_id = Auth::id();
        $businessProfile->company_name = $data['company_name'];
        $businessProfile->company_address = $data['company_address'];
        $businessProfile->company_website = $data['company_website'];
        $businessProfile->industry_id = $data['industry'];
        $businessProfile->area_of_service = config('constant.inverse_area_of_service.'.$data['area_of_service']);
        $businessProfile->save();
    }

    private function _createUser($data)
    {
        $userProfile = new UserProfile;
        $userProfile->user_id = Auth::id();
        $userProfile->full_name = $data['name'];
        $userProfile->address = $data['address'];
        $userProfile->share_profile = config('constant.inverse_share_profile.'.$data['share_profile']);
        $userProfile->loan_status = config('constant.inverse_loan_status.'.$data['loan_status']);
        $userProfile->first_name = $data['first_name'];
        $userProfile->middle_name = $data['middle_name'];
        $userProfile->last_name = $data['last_name'];
        $userProfile->electronic_signature = $data['electronic_signature'];
        $userProfile->save();
    }

    public function profileImage(ProfileImageRegisterRequest $request): JsonResponse
    {
        if ($request->hasFile('profile_image')) {

            $user = User::where('id', Auth::id())->first();
            File::delete(storage_path(config('constant.profile_images_path').Auth::id().'/'.$user->image));
            $imageName = store_profile_image($request->profile_image);

            $Input['image'] = $imageName;
            if (User::where('id', Auth::id())->update($Input)) {

                return response()->json(['success' => true,
                    'imageName' => $imageName, 'message' => 'Profile Image saved successfully.'], 200);
            }

            return response()->json(['success' => false, 'message' => 'Profile Image not saved.'], 500);
        }

        return response()->json(['success' => false, 'message' => 'Please enter a valid image.'], 500);
    }

    public function editPassword(): View
    {
        return view('frontend.user.password_change');
    }

    public function passwordChange(PasswordChangeRegisterRequest $request): RedirectResponse
    {
        if (Auth::check()) {

            if (! Hash::check($request->old_password, Auth::user()->password)) {
                return redirect()->back()->with('flash_danger', 'Please specify the good current password');
            }

            $input['password'] = Hash::make($request->password);
            if (User::where('id', Auth::id())->update($input)) {

                return redirect()->route('frontend.user.dashboard')->with('flash_success', 'Password updated successfully.');
            }

            return redirect()->back()->with('flash_success', 'Password Updation Failed.');
        }
    }
}
