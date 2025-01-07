<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SearchedRentPropertyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'state' => [
                'required',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}
