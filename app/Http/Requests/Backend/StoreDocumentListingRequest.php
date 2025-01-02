<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentListingRequest extends FormRequest
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
            'document' => [
                'required',
                'mimes:pdf',
            ],
        ];
    }
}
