<?php

namespace App\Http\Requests\Frontend\Contact;

use App\Http\Requests\Request;

/**
 * Class SendContactRequest.
 */
class SendContactRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'email' => [
                'required',
            ],
            'phone' => [
                'required',
            ],
            'address' => [
                'required',
            ],
            'comment' => [
                'required',
            ],
            //'g-recaptcha-response' => 'required_if:captcha_status,true|captcha',
            'g-recaptcha-response' => [
                'required',
            ],
            'captcha_status' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required_if' => trans('validation.required', ['attribute' => 'captcha']),
        ];
    }
}
