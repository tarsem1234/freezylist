<?php

namespace App\Http\Requests\Frontend\Auth;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class RegisterRequest.
 */
class RegisterRequest extends Request
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
            'first_name' => [
                'required',
                'string',
                'max:191',
            ],
            'last_name' => [
                'required',
                'string',
                'max:191',
            ],
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
            'g-recaptcha-response' => [
                'required_if:captcha_status,true',
                'captcha',
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
