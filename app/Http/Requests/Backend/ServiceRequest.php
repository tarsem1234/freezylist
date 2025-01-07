<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'industry' => [
                'required',
            ],
            'service' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'industry.required' => 'The Industry field is required.',
            'service.required' => 'The Service field is required.',
        ];
    }
}
