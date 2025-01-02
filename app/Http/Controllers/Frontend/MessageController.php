<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ConversationMessageRequest;
use App\Mail\Frontend\SendMessageToSeller;
use App\Models\Access\User\User;
use App\Models\Message;
use App\Models\Network;
use App\Models\ProfileRating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index()
    {
        // $messages = Message::where('to_user_id', Auth::id())->orWhere('user_id', Auth::id())->get();
        // \DB::enableQueryLog();
        $messages = Message::where(function ($query) {
            $query->where('to_user_id', Auth::id())
                ->whereHas('fromUserInbox', function ($query) {
                    $query->withTrashed();
                })->latest();
        })->orWhere(function ($query) {
            $query->where('user_id', Auth::id())
                ->whereHas('fromUserInboxCheck', function ($query) {
                    $query->withTrashed();
                })->latest();
        })->get();
        // User::withTrashed()->find($id)
        $conversationWith = [];
        foreach ($messages as $message) {
            if (! in_array($message->user_id, $conversationWith) && $message->user_id != Auth::id()) {
                $conversationWith[] = $message->user_id;
            }
            if (! in_array($message->to_user_id, $conversationWith) && $message->to_user_id != Auth::id()) {
                $conversationWith[] = $message->to_user_id;
            }
        }
        $messages = collect();
        foreach ($conversationWith as $userID) {
            $latestMessage = Message::where(function ($q) use ($userID) {
                return $q->where('user_id', $userID)->where('to_user_id', Auth::id());
            })->orWhere(function ($q) use ($userID) {
                return $q->where('user_id', Auth::id())->where('to_user_id', $userID);
            })->orderByDesc('created_at')->first();
            $otherUser = $latestMessage->user_id == Auth::id() ? $latestMessage->to_user_id : $latestMessage->user_id;
            $messages[] = (object) [
                'created_at' => $latestMessage->created_at,
                'otherUser' => User::withTrashed()->find($otherUser),
                'status' => $latestMessage->status,
                'toUserId' => $latestMessage->to_user_id,
            ];
        }
        $messages = $messages->sortByDesc('created_at');

        return view('frontend.messages.index', compact('messages'));
    }

    public function conversation(Request $request, $id)
    {
        $id = decrypt($id);
        if(User::where('id', $id)->withTrashed()->exists()) {
            $fromUser = User::withTrashed()->find($id);
            if ($request->isMethod('post')) {
                if ($request->isMethod('post')) {
                $this->validate($request, [
            'message' => 'required',
        ]);
                $message             = new Message;
                $message->user_id    = Auth::id();
                $message->to_user_id = $id;
                $message->message    = $request->get('message', '');
                $toUserData = User::where('id', $id)->with(['user_profile', 'business_profile'])->first();  
                if($message->save()) {
                    $to = $toUserData->email;
                    $emailSubject = "Freezylist :  You have received a new message.";
                    $userName = getFullName($toUserData );
                    $sender = getFullName(Auth::user());
                    $conversationLInk = route('frontend.messages.conversation', encrypt(Auth::id()));
                    $emailBody = "Hi " . $userName . "You have received a new message from " . $sender . ' ' . $request->message . "For replying to this message please go to Your Frezylist Inbox or click on following link. " . $conversationLInk;
                    $view = "frontend.messages.sendMessageToSellerMail";
            
                    Mail::send(new SendMessageToSeller($to, $userName, $sender, $emailSubject, $emailBody, $view, $conversationLInk, $request->message));
            
                    // $saveLog = new EmailLogService();
                    // $saveLog->saveLog($property->id, Auth::id(), $property->user_id, $emailSubject, $emailBody, config('constant.property_type.' . $property->property_type), url()->previous());
                    }
                return redirect()->back()->withFlashSuccess("Message has been sent");
            }
            }
            $messages = Message::where(function ($query) use($id) {
                $query->where('user_id', $id)->where('to_user_id', Auth::id());
            })->orWhere(function ($query) use($id) {
                $query->where('user_id', Auth::id())->where('to_user_id', $id);
            })->with(['fromUser'=>function($query){
                $query->withTrashed();
            }])->orderBy('created_at')->get();

            $network = Network::where(function ($query) use($id){
                $query->where('from_user_id', $id)->where('to_user_id', Auth::id());
                $query->orWhere('from_user_id', Auth::id())->where('to_user_id', $id);
            })->withTrashed()->latest()->first();
            
            
  
            foreach ($messages as $message) {
                if ($message->user_id != auth()->id()) {
                    $message->status = 1;
                    $message->save();
                }
            }
            return view('frontend.messages.conversation', compact('messages', 'fromUser','network'));
        }
        return redirect()->back()->withFlashDanger('User is not in your network anymore');
    }

    public function areFriends($firstUser, $secondUser)
    {
        $friends = Network::where(function ($query) use ($firstUser, $secondUser) {
            $query->where('from_user_id', $firstUser)->where('to_user_id', $secondUser);
        })->orWhere(function ($query) use ($firstUser, $secondUser) {
            $query->where('to_user_id', $firstUser)->where('from_user_id', $secondUser);
        })
            ->where('status', 1)
            ->first();

        return $friends ? true : false;
    }

    public function rateUser(Request $request): Response
    {
        $rating = ProfileRating::where(['from_user_id' => Auth::id(), 'user_id' => $request->get('user_id')])->first() ?? new ProfileRating;
        $rating->review = $request->get('review', null);
        $rating->user_id = $request->get('user_id', 0);
        $rating->rating = $request->get('rating', 0);
        $rating->from_user_id = Auth::id();
        $user = User::find($rating->user_id);
        if ($rating->save()) {
            return response(['rating' => $user->rating]);
        }
    }

    public function userReviews($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('frontend.network_portal.reviews', ['ratings' => $user->ratings()->paginate(config('constant.common_pagination'))]);
        }

        return redirect()->back()->withFlashDanger('User not found');
    }

    public function composeNew(Request $request)
    {
        $allAssociates = Network::where(function ($query) {
            $query
                ->where('from_user_id', Auth::id())
                ->orWhere('to_user_id', Auth::id());
        })
            ->where('status', config('constant.inverse_network_request.accepted'))
            ->get();
        if ($request->isMethod('post')) {
            $message = new Message;
            $message->user_id = Auth::id();
            $message->to_user_id = $request->get('id');
            $message->message = $request->get('message', '');
            $toUserData = User::where('id', $request->get('id'))->with(['user_profile', 'business_profile'])->first();
            if($message->save()) {
                $to = $toUserData->email;
                $emailSubject = "Freezylist :  You have received a new message.";
                $userName = getFullName($toUserData );
                $sender = getFullName(Auth::user());
                $conversationLInk = route('frontend.messages.conversation', encrypt(Auth::id()));
                $emailBody = "Hi " . $userName . "You have received a new message from " . $sender . ' ' . $request->message . "For replying to this message please go to Your Frezylist Inbox or click on following link. " . $conversationLInk;
                $view = "frontend.messages.sendMessageToSellerMail";
        
                Mail::send(new SendMessageToSeller($to, $userName, $sender, $emailSubject, $emailBody, $view, $conversationLInk, $request->message));
        
                // $saveLog = new EmailLogService();
                // $saveLog->saveLog($property->id, Auth::id(), $property->user_id, $emailSubject, $emailBody, config('constant.property_type.' . $property->property_type), url()->previous());
                }

            return redirect()->back()->withFlashSuccess('Message has been sent');
        }
        $allAssociates = $allAssociates->map(function ($network, $index) {
            return ['id' => $network->associate->id, 'name' => getFullName($network->associate)];
        })->pluck('name', 'id');

        return view('frontend.messages.new', compact('allAssociates'));
    }

    public function delete($id): RedirectResponse
    {
        $id = decrypt($id);
        if ($id) {
            Message::where(function ($query) use ($id) {
                $query->where('user_id', Auth::id())->where('to_user_id', $id);
            })->orWhere(function ($query) use ($id) {
                $query->where('user_id', $id)->where('to_user_id', Auth::id());
            })->forcedelete();

            return redirect()->route('frontend.messages.index');
        }

        return redirect()->back()->with(['flash_danger' => 'Something went wrong.']);
    }
}
