<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertiseImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'page_link' => [
                'required',
            ],
            'advertise_image' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png',
                'max:1024',
            ],
        ];
    }
}
