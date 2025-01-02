<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SignStoreSignerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'county' => [
                'required',
            ],
            'zip_code' => [
                'required',
            ],
            'city' => [
                'required',
            ],
            'state' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            'phone_no' => [
                'required',
                'max:10',
            ],
            'email' => [
                'required',
                'email',
            ],
        ];
    }
}
