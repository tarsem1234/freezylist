<?php

namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;

/**
 * Class UpdateUserPasswordRequest.
 */
class UpdateUserPasswordRequest extends Request
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
        return [
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
        ];
    }
}
