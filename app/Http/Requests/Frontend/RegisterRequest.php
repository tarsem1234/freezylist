<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

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
        $userType = ['User', 'Business'];
        $rules = [
            'user_type' => [
                'required',
                Rule::in($userType),
            ],
            'password' => 'required|min:6|confirmed',
            'state' => 'required',
            'county' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'phone_no' => 'required',
            'g-recaptcha-response' => 'required',
            'captcha_status' => 'required',
        ];
        if ($this->savedTime && $this->code) {
            $rules += [
                'email' => 'required|email',
            ];
        } else {
            $rules += [
                'email' => 'required|email|unique:users',
            ];
        }
        if ($this->user_type == config('constant.user_type.3')) {
            $rules += [
                'name' => 'required|max:50',
                'address' => 'required',
                'interest' => 'required',
                'share_profile' => 'required',
                'loan_status' => 'required',
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:50',
                'electronic_signature' => 'required',
                'g-recaptcha-response' => 'required',
                'captcha_status' => 'required',
            ];
        }
        if ($this->user_type == config('constant.user_type.2')) {
            $rules += [
                'company_name' => 'required',
                'company_address' => 'required',
                'company_website' => 'required',
                'industry' => 'required',
                'services' => 'required',
                'area_of_service' => 'required',
                'g-recaptcha-response' => 'required',
                'captcha_status' => 'required',
            ];
        }

        //dd($rules);
        return $rules;
    }

    public function messages(): array
    {
        return [
            //            'g-recaptcha-response.required_if' => trans('validation.required',
            //                ['attribute' => 'captcha']),
        ];
    }
}
