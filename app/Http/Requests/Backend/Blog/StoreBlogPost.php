<?php

namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
            'blog_title' => [
                'required',
                'min:5',
                'max:191',
            ],
            'blog_description' => [
                'required',
            ],
            'blog_content' => [
                'required',
            ],
            'blog_image' => [
                'required',
            ],
        ];
    }
}
