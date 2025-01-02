<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class TenantQuestionnaireRequest extends Request
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
        $sellerAware = [1, 2];
        $rules = [
            'joint_cowners' => [
                'required',
                Rule::in($sellerAware),
            ],
        ];
        if ($this->joint_cowners == config('constant.inverse_yes_no.Yes')) {
            $rules += [
                'select-email.*' => 'required|email',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [];
    }
    //    public function all()
    //    {
    //        $data = parent::all();
    //
    //        return $data;
    //    }
}
