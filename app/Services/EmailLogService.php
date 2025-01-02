<?php

namespace App\Services;

use App\Models\AutoEmailLog;

class EmailLogService
{
    /**
     * Get the currently authenticated user or null.
     */
    public function saveLog($propertyId = null, $toUserId = null,
        $fromUserId = null, $subject = null, $body = null,
        $flag = null, $source = null)
    {
        $autoEmailLog = new AutoEmailLog;

        $autoEmailLog->property_id = $propertyId;
        $autoEmailLog->to_user_id = $toUserId;
        $autoEmailLog->from_user_id = $fromUserId;

        $autoEmailLog->message = $body;
        $autoEmailLog->email_subject = $subject;
        $autoEmailLog->flag = $flag;
        $autoEmailLog->source_script = $source;
        $autoEmailLog->save();

        return true;
    }
}
