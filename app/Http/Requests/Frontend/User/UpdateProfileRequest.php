<?php

namespace App\Http\Requests\Frontend\User;

use App\Http\Requests\Request;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends Request
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
                'max:191',
            ],
            'last_name' => [
                'required',
                'max:191',
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:191',
            ],
        ];
    }
}
