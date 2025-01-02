<?php

namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;

/**
 * Class UpdateUserRequest.
 */
class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return access()->hasRole(1);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->submit == 'Business') {
            return [
                'email' => [
                    'required',
                    'email',
                    'max:191',
                ],
                'company_name' => [
                    'required',
                    'max:191',
                ],
                'industry' => [
                    'required',
                ],
                //                'city' => 'required|max:15',
            ];
        }
        if ($this->submit == 'Administrator' || $this->submit == 'Support') {
            return [
                'first_name' => [
                    'required',
                    'max:191',
                ],
                'last_name' => [
                    'required',
                    'max:191',
                ],
            ];
        }

        return [
            'email' => [
                'required',
                'email',
                'max:191',
            ],
            'name' => [
                'required',
                'max:191',
            ],
            //            'city' => 'required|max:191',
            'phone_no' => [
                'required',
                'numeric',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
            ],
        ];
    }
}
