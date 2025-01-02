<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StoreForumRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'forum_topic' => [
                'required',
            ],
            'forum_detail' => [
                'required',
            ],
        ];
    }
}
