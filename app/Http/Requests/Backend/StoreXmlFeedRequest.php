<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreXmlFeedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'unique:xmlfeed_users',
                'max:191',
            ],
            'password' => [
                'required',
                'max:191',
            ],
        ];
    }
}
