<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorySessionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:150',
            ],
            'description' => [
                'required',
            ],
            'points' => [
                'required',
            ],
            'questions' => [
                'required',
            ],
        ];
    }
}
