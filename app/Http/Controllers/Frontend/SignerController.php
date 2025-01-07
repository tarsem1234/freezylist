<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContractToolSignerSignerRequest;
use App\Http\Requests\Frontend\SignStoreSignerRequest;
use App\Models\Access\User\User;
use App\Models\Network;
use App\Models\Signer;
use App\Models\State;
use App\Models\UserProfile;
use App\Notifications\Frontend\Auth\RecieverNeedsLogin;
use App\Notifications\Frontend\Auth\SenderNeedsConfirmation;
use App\Notifications\Frontend\Auth\SenderNeedsRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SignerController extends Controller
{
    public function index(): View
    {
        $signers = Signer::where('from_user_id', Auth::id())->whereHas('invited_users')->with([
            'invited_users' => function ($query) {
                $query->with('user_profile', 'business_profile');
            }])->latest()->paginate(config('constant.common_pagination'));

        //        dd($signers);
        return view('frontend.signer.index', compact('signers'));
    }

    public function create(): View
    {

        return view('frontend.signer.create');
    }

    public function signStore(SignStoreSignerRequest $request): RedirectResponse
    {
        $exists = User::where('email', $request->email)->with('roles')->first();
        $ifNewUser = true;
        $ifSignerExists = null;
        if ($exists) {
            $ifNewUser = false;
            $ifSignerExists = Signer::where('from_user_id', Auth::id())->where('invited_user_id', $exists->id)->first();
        }
        if ($ifSignerExists) {
            $exists->notify(new SenderNeedsRegistration($exists->confirmation_code, $exists->first_name, $request->property_id));

            return redirect()->route('frontend.signer.index')->with('flash_danger', 'Signer Already Exist.');
        }
        if (! $exists && ! $ifSignerExists) {
            $exists = $this->_createUser($request, $ifNewUser);
        }
        //dd($exists->toArray());
        if ($exists && $exists->id != Auth::id() && Auth::check() && $exists->roles[0]->name == 'User') {
            $this->_storeSigner($exists);
            $newUser = new User;
            $newUser->email = $exists->email;
            $newUser->confirmation_code = $exists->confirmation_code;
            $newUser->created_at = $exists->created_at;
            //                $newUser->email = $request->email;
            if ($exists->status == 0) {
                $newUser->notify(new SenderNeedsRegistration($exists->confirmation_code, $exists->first_name));
            } else {
                $exists->notify(new RecieverNeedsLogin($exists->confirmation_code, $exists->first_name));
            }

            return redirect()->route('frontend.signer.index')->with('flash_success', 'Signer saved successfully.');
        }

        return redirect()->route('frontend.signer.index')->with('flash_success', 'Already sent.');
    }

    //    create Signer
    private function _createUser($request, $ifNewUser)
    {

        if (! empty($request->state)) {
            $checkState = State::where('state', $request->state)->first();
            if (! $checkState) {
                return response()->json(['message' => 'State not found.',
                    'success' => false], 500);
            }
        } else {
            $checkState = '';
        }

        $user = new User;
        $user->first_name = $request->name;
        $user->status = config('constant.inverse_signer_status.Inactive');
        $user->email = $request->email;
        $user->state_id = ! empty($checkState['id']) ? $checkState['id'] : '';
        $user->zip_code = ! empty($request->zip_code) ? $request->zip_code : '';
        $user->county = ! empty($request->county) ? $request->county : '';
        $user->city = ! empty($request->city) ? $request->city : '';
        $user->phone_no = ! empty($request->phone_no) ? $request->phone_no : '';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        if ($user->save()) {
            $userProfile = new UserProfile;
            $userProfile->user_id = $user->id;
            $userProfile->full_name = ! empty($request->name) ? $request->name : $request->first_name.''.$request->last_name;
            $userProfile->address = ! empty($request->address) ? $request->address : '';
            $userProfile->first_name = $request->first_name;
            $userProfile->middle_name = $request->middle_name;
            $userProfile->last_name = $request->last_name;
            $userProfile->electronic_signature = $request->first_name.' '.$request->middle_name.' '.$request->last_name;
            //                    $user->secure_code = $data['phone_no'];
            if ($userProfile->save()) {

                $user->attachRole(config('constant.inverse_user_type.User'));   //assign user role
            }
        }

        //        if ($ifNewUser) {
        //            $user->notify(new SenderNeedsRegistration($user->confirmation_code));
        //        }
        return $user;
    }

    private function _storeSigner($exists)
    {
        $signer = new Signer;
        $signer->from_user_id = Auth::id();
        $signer->invited_user_id = $exists->id;
        $signer->save();

        return $signer;
    }

    public function resendActivation($id): RedirectResponse
    {
        if (Auth::check() && $id) {
            $ifExists = User::find($id);

            if ($ifExists) {
                $input['confirmation_code'] = md5(uniqid(mt_rand(), true));
                User::where('id', $id)->update($input);
                $user = new User;
                $user->email = $ifExists->email;
                $user->notify(new SenderNeedsConfirmation($input['confirmation_code']));

                return redirect()->route('frontend.signer.index')->with('flash_success', 'The activation email send successfully.');
            }

            return redirect()->route('frontend.signer.index')->with('flash_success', 'The activation email failed.');
        }

        return redirect()->route('frontend.index')->with('flash_success', 'Something went wrong, please try later.');
    }

    public function accountConfirm($token)
    {
        if ($token) {
            $isConfirmed = User::where('confirmation_code', $token)->first();

            if ($isConfirmed->password == null) {
                $user = User::where('confirmation_code', $token)->with('user_profile', 'business_profile')->first();
                // return redirect()->route('frontend.userCreate')->with('user',$user);                    // New user needs register all data.
                if (! empty($user->state_id)) {
                    $state = State::where('id', $user->state_id)->pluck('state')->first();
                } else {
                    $state = null;
                }
                if ($user) {
                    return view('frontend.userRegister.userCreate', compact('user', 'state'));
                } else {

                    return redirect()->route('frontend.auth.login')->with('flash_danger', 'Invalid URL.');
                }
            }

            if ($isConfirmed) {
                $input['status'] = config('constant.inverse_signer_status.Active');
                $input['confirmed'] = 1;
                User::where('id', $isConfirmed->id)->update($input);

                return redirect()->route('frontend.auth.login')->with('flash_success', 'Signer activation successfully.');
            }

            return redirect()->route('frontend.signer.index')->with('flash_success', 'Signer activation failed.');
        }

        return redirect()->route('frontend.index')->with('flash_success', 'Token missing, please try later.');
    }

    public function signerView($id)
    {
        if (Auth::check() && $id) {

            $user = User::where('id', $id)->with('lerning_points')
                ->with(['user_profile' => function ($query) {
                    $query->with('user_interests');
                }, 'business_profile'])->first();
            $network = Network::where('from_user_id', Auth::id())->where('to_user_id', $id)->first();

            //            dump($user->toArray());
            //            dd($network->toArray());
            return view('frontend.signer.user_details', compact('user', 'network'));
        }

        return redirect()->route('frontend.index')->with('flash_success', 'Something went wrong, please try later.');
    }

    public function deleteSigner($id)
    {
        if ($id && Auth::check()) {
            if (Signer::where('id', $id)->delete()) {

                return redirect()->route('frontend.signer.index')->with('flash_success', 'Signer deleted successfully.');
                //            return response()->json(['success' => true, 'message' => 'Signer deleted successfully'],
                //                    200);
            }
        }

        return redirect()->route('frontend.signer.index')->with('flash_success', 'Signer Deletion Failed.');
        //        return response()->json(['success' => true, 'message' => 'Signer Deletion Failed'],
        //                500);
    }

    public function contractToolSigner(ContractToolSignerSignerRequest $request): JsonResponse
    {
        if (! empty($request->type) && $request->type == 'rent') {
        } else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'first_name' => 'required',
                'last_name' => 'required',
                //            'property_id' => 'required',
            ]);
        }
        $exists = User::where('email', $request->email)->with('roles', 'user_profile', 'business_profile')->first();

        if ($exists && $exists->id == Auth::id()) {
            return response()->json(['message' => 'You cant add yourself as signer',
                'success' => false], 500);
            //return you can not add yorself as a signer
        } elseif ($exists && ! ($exists->roles[0]->name == 'User' || $exists->roles[0]->name == 'Business')) {
            return response()->json(['message' => 'This user is not allowed to be added as a signer.',
                'success' => false], 500);
            //return this user is not allowed to be added as a signer
        }
        if ($exists) {
            $ifNewUser = false;
            $ifSignerExists = Signer::where('from_user_id', Auth::id())->where('invited_user_id', $exists->id)->first();
            if ($ifSignerExists) {
                $exists->notify(new SenderNeedsRegistration($exists->confirmation_code, $exists->first_name, $request->property_id));

                return response()->json(['message' => 'The signer has already added.',
                    'success' => false], 500);
            }
        } else {
            $ifNewUser = true;
            $ifSignerExists = null;
        }

        if (! $exists && ! $ifSignerExists) {
            $exists = $this->_createUser($request, $ifNewUser);
        }

        if ($exists && ($exists->roles[0]->name == 'User' || $exists->roles[0]->name == 'Business')) {
            // Need to check why the above condition put there.
            //        dd($exists->toArray());

            //            dd($exists);
            $this->_storeSigner($exists);
            $newUser = new User;
            $newUser->email = $exists->email;
            $newUser->confirmation_code = $exists->confirmation_code;
            $newUser->created_at = $exists->created_at;
            //               $newUser->email = $request->email;
            if ($exists->status == 0) {
                $newUser->notify(new SenderNeedsRegistration($exists->confirmation_code, $exists->first_name, $request->property_id));
            } else {
                $exists->notify(new RecieverNeedsLogin($exists->confirmation_code, $exists->first_name));
            }

            $signers = Signer::where('from_user_id', Auth::id())->has('invited_users')->with(['invited_users' => function ($query) {
                $query->with('user_profile', 'business_profile');
            }])->get();

            return response()->json(['success' => true, 'signers' => $signers], 200);
        }

        return response()->json(['signers' => ''], 500);
    }
}
