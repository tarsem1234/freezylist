<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContractToolSignerSignerRequest extends FormRequest
{
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
                'email',
            ],
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
        ];
    }
}
