<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ProfileImageRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return ['profile_image' => [
            'required',
            'mimes:jpeg,jpg,png',
            'max:1000',
        ], ];
    }
}
