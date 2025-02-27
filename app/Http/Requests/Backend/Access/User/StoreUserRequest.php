<?php

namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class StoreUserRequest.
 */
class StoreUserRequest extends Request
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
        if ($this->submit == 'Create') {
            return [
                'email' => ['required', 'email', 'max:191', Rule::unique('users')],
                'password' => [
                    'required',
                    'min:6',
                    'confirmed',
                ],
            ];
        }

        return [
            'first_name' => [
                'required',
                'max:191',
            ],
            'last_name' => [
                'required',
                'max:191',
            ],
            'email' => ['required', 'email', 'max:191', Rule::unique('users')],
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
        ];
    }
}
