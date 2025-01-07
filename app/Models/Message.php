<?php

namespace App\Models;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use SoftDeletes;

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, $this->user_id === Auth::id() ? 'user_id' : 'to_user_id');
    }

    public function fromUserInbox(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'user_id');
    }

    public function fromUserInboxCheck(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'to_user_id');
    }

    public static function logToDB($toUserId, $messageContent, $fromUserId = null)
    {
        $user = User::find($toUserId);
        if ($user) {
            if (empty($messageContent)) {
                return ['status' => 'failed', 'message' => 'Message content can not be empty'];
            }
            $message = new Message;
            $message->user_id = $fromUserId ?? Auth::id();
            $message->to_user_id = $toUserId;
            $message->message = $messageContent;
            if ($message->save()) {
                return ['status' => 'success', 'message' => 'Message has been logged'];
            } else {
                return ['status' => 'failed', 'message' => 'Something went wrong!!'];
            }
        } else {
            return ['status' => 'failed', 'message' => 'User not found'];
        }
    }
}
