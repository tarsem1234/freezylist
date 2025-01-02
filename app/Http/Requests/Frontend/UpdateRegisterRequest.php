<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateRegisterRequest extends Request
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
            'email' => 'required',
            'state' => 'required',
            //            'county' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'phone_no' => 'required',
        ];
        if ($this->user_type == config('constant.user_type.3')) {
            $rules += [
                'name' => 'required',
                'address' => 'required',
                'interest' => 'required',
                'share_profile' => 'required',
                'loan_status' => 'required',
                'first_name' => 'required',
                //                'middle_name' => 'required',
                'last_name' => 'required',
                'electronic_signature' => 'required',
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
            ];
        }

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
