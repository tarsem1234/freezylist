<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Message;
use App\Models\Network;
use App\Models\Recommendation;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NetworkController extends Controller
{
    public function socialNetwork(): View
    {
        $states = state::get();
        $request = null;

        return view('frontend.network_portal.social', compact('states', 'request'));
    }

    public function supportNetwork(): View
    {
        $states = state::get();
        $request = null;

        return view('frontend.network_portal.support', compact('states', 'request'));
    }

    public function searchedSocialNetwork(Request $request)
    {
        return $this->_searchedNetwork($request, config('constant.user_type.3'), 'frontend.network_portal.social');
    }

    public function searchedSupportNetwork(Request $request)
    {
        return $this->_searchedNetwork($request, config('constant.user_type.2'), 'frontend.network_portal.support');
    }

    private function _searchedNetwork(Request $request, $userType, $viewPage)
    {
        $search = $this->_searchNetworkUser($request, $userType);

        $haversine = null;
        if ($request->latitude && $request->longitude) {

            $haversine = "( 3958 * acos(cos(radians($request->latitude)) * cos(radians(latitude))
                    * cos(radians(longitude) - radians($request->longitude)) + sin(radians($request->latitude))
                    * sin(radians(latitude))))";
        }

        if ($request->zip && $request->radius) {
            $search->selectRaw("id,city,zip_code,county,state_id,image,'{$haversine}' AS distance")->whereRaw("'{$haversine}' < ?", [$request->radius]);
            // $search->selectRaw("id,city,zip_code,county,state_id,image, {$haversine} AS distance")->whereRaw("{$haversine} < ?", [$request->radius]);
        } elseif ($request->state && $request->zip && ! $request->radius) {
            $search->where('state_id', $request->state)->where('zip_code', $request->zip);
        } else {
            $search->where('state_id', $request->state);
        }
        $states = state::get();
        $searchResult = $search->latest()->paginate($request->limit ? $request->limit : config('constant.common_pagination'));

        return view($viewPage, compact('states', 'request'))->with(['search' => $searchResult]);
    }

    private function _searchNetworkUser($request, $userType)
    {
        $search = User::where('id', '!=', Auth::id())->where('status', 1)->where('confirmed', 1);
        if ($userType == config('constant.user_type.3')) {

            $search->whereHas('user_profile', function ($query) use ($request) {
                $query->where('share_profile', config('constant.inverse_share_profile.Yes'));
                if ($request->name) {
                    $query->where('full_name', 'LIKE', '%'.$request->name.'%');
                }
            })->whereHas('roles', function ($query) {
                $query->where('name', config('constant.user_type.3'));
            })->with(['user_profile']);
        } else {

            $search->whereHas('business_profile', function ($query) use ($request) {
                if ($request->name) {
                    $query->where('company_name', 'LIKE', '%'.$request->name.'%');
                }
                if ($request->industry) {
                    $query->where('industry_id', $request->industry);
                }
            })->whereHas('roles', function ($query) {
                $query->where('name', config('constant.user_type.2'));
            })->with(['business_profile']);
        }

        return $search;
    }

    public function myNetwork(): View
    {
        // \DB::enableQueryLog();
        $allAssociates = Network::where(function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->where('from_user_id', Auth::id())
                    ->whereHas('request_to_user', function ($query) {
                        $query->where('status', 1);
                    });
            })->orWhere(function ($subQuery) {
                $subQuery->where('to_user_id', Auth::id())
                    ->whereHas('request_from_user', function ($query) {
                        $query->where('status', 1);
                    });
            });
        })->with(['request_from_user' => function ($subQuery) {
            $subQuery->where('id', '!=', Auth::id());
        }, 'request_to_user' => function ($subQuery) {
            $subQuery->where('id', '!=', Auth::id());
        }])
            ->where('status', config('constant.inverse_network_request.accepted'))
            ->paginate(config('constant.common_pagination'));

        // dump(\DB::getQueryLog());
        //dd($allAssociates);

        return view('frontend.network_portal.my_network', compact('allAssociates'));
    }

    public function userDetails(Request $request, $id)
    {
        if ($id != Auth::id()) {
            $user = User::where('id', $id)
                ->with('roles', 'business_profile', 'lerning_points')
                ->with(['user_profile' => function ($query) {
                    $query->with('user_interests');
                }])->first();
            // echo'<pre>';print_r($user);die;
            if (! empty($user)) {
                $network = Network::where(function ($query) use ($id) {
                    $query->where('from_user_id', Auth::id())
                        ->where('to_user_id', $id);
                })->orWhere(function ($query) use ($id) {
                    $query->where('from_user_id', $id)
                        ->where('to_user_id', Auth::id());
                })->first();
                $userRating = $user->ratings()->where('from_user_id', Auth::id())->first();
                $recommended = Recommendation::where(['user_id' => $id, 'from_user_id' => Auth::id()])->first();
                $recommendations = Recommendation::where(['user_id' => $id])->get()->count();

                return view('frontend.network_portal.user_details', compact('user', 'network', 'userRating', 'recommended', 'recommendations'));
            }
        }

        return redirect()->back();
    }

    public function requestSent($id): RedirectResponse
    {
        if (Auth::id() != $id) {
            $exists = Network::where('from_user_id', Auth::id())->where('to_user_id', $id)->first();
            if (Auth::check() && empty($exists)) {

                $sentRequest = new Network;

                $sentRequest->from_user_id = Auth::id();
                $sentRequest->to_user_id = $id;
                $sentRequest->status = config('constant.inverse_offer_status.pending');

                if ($sentRequest->save()) {
                    $recipientMessageContent = 'May I join your network? <br> Has requested to join your network at freezylist.com.';
                    Message::logToDB($id, $recipientMessageContent);

                    return redirect()->back()->withFlashSuccess('Add request sent successfully.');
                }
            }
        }

        return redirect()->back()->withFlashSuccess('Request already sent.');
    }

    public function receivedRequests()
    {
        if (Auth::check()) {

            $requests = Network::where('to_user_id', Auth::id())->where('status', 0)->has('request_from_user')->with(['request_from_user' => function ($query) {
                $query->with('user_profile', 'business_profile');
            }])->paginate(config('constant.common_pagination'));

            return view('frontend.network_portal.recieved_requests', compact('requests'));
        }

        return redirect()->back()->withFlashSuccess('Request already sent.');
    }

    public function sentRequests()
    {
        if (Auth::check()) {
            $requests = Network::where('from_user_id', Auth::id())->where('status', 0)->has('request_to_user')->with(['request_to_user' => function ($query) {
                $query->with('user_profile', 'business_profile');
            }])->paginate(config('constant.common_pagination'));

            //        dd($requests->toArray());
            return view('frontend.network_portal.sent_requests', compact('requests'));
        }

        return redirect()->back()->withFlashSuccess('Request already sent.');
    }

    public function acceptRequest($id): RedirectResponse
    {
        if (Auth::check()) {
            $input['status'] = config('constant.inverse_network_request.accepted');
            if (Network::where('to_user_id', Auth::id())
                ->where('from_user_id', $id)->update($input)) {

                $senderMessageContent = 'Hi, your request has been accepted.';
                Message::logToDB($id, $senderMessageContent);

                return redirect()->back()->withFlashSuccess('Request has been accepted successfully');
            }

            return redirect()->back()->withFlashWarning('Request acceptance failed.');
        }
    }

    public function rejectRequest($id): RedirectResponse
    {
        if (Auth::check()) {
            if (Network::where('to_user_id', Auth::id())
                ->where('from_user_id', $id)->forcedelete()) {
                return redirect()->back()->withFlashSuccess('Request deleted successfully');
            }

            return redirect()->back()->withFlashWarning('Request deletion failed.');
        }
    }

    public function cancelRequest($id): RedirectResponse
    {
        if (Auth::check()) {
            if (Network::where('from_user_id', Auth::id())
                ->where('to_user_id', $id)->forcedelete()) {
                return redirect()->back()->withFlashSuccess('Request canceled successfully');
            }

            return redirect()->back()->withFlashWarning('Request cancelation failed.');
        }
    }

    public function deleteConnection($id): RedirectResponse
    {
        if (Auth::check() && $id) {
            if (Network::where(function ($q) {
                $q->where('from_user_id', Auth::id())
                    ->orWhere('to_user_id', Auth::id());
            })->where('id', $id)->first()->delete()) {
                return redirect()->back()->withFlashSuccess('Connection removed successfully');
            }

            return redirect()->back()->withFlashWarning('Failed to remove Connection.');
        }
    }

    public function profileRating(Request $request): Response
    {
        if (Auth::check()) {

            $rate = new ProfileRate;

            $rate->from_user_id = Auth::id();
            $rate->to_user_id = $request->rated_id;
            $rate->rating = $request->rating;

            if ($rate->save()) {
                return response(['success' => true, 'message' => 'Rated successfully.']);
            }

            return response(['success' => false, 'message' => 'Rating failed.'], 500);
        }
    }

    public function recommendBusiness($userId)
    {
        $user = User::find($userId);
        if (! $user && ! isset($user->business_profile)) {
            return redirect()->back()->withFlashDanger('User not found');
        }
        $recommended = Recommendation::where(['user_id' => $userId, 'from_user_id' => Auth::id()])->first();
        if ($recommended) {
            return redirect()->back()->withFlashDanger('You already recommended this');
        }
        $recommend = new Recommendation;
        $recommend->user_id = $userId;
        $recommend->from_user_id = Auth::id();
        if ($recommend->save()) {
            $recommended = Recommendation::where(['user_id' => $userId, 'from_user_id' => Auth::id()])->first();
            $recommendations = Recommendation::where(['user_id' => $userId])->get()->count();

            return response(['recommended' => $recommended, 'recommendations' => $recommendations, 'success' => true, 'message' => 'Recommended Successfully!!']);
        }

        return response(['success' => false, 'message' => 'Recommendation failed.'], 500);
    }
}
