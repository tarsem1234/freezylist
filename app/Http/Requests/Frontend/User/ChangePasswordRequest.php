<?php

namespace App\Http\Requests\Frontend\User;

use App\Http\Requests\Request;

/**
 * Class ChangePasswordRequest.
 */
class ChangePasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return access()->user()->canChangePassword();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
        ];
    }
}
