<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'blog_title' => [
                'required',
            ],
            'blog_description' => [
                'required',
            ],
            'blog_content' => [
                'required',
            ],
        ];
    }
}
