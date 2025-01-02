<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BuyerQuestionnaireRequest extends Request
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
            'using_VA_or_FHA' => 'required',
            'set_specific_date' => [
                'required',
                Rule::in($sellerAware),
            ],
            'addendum' => [
                'required',
                Rule::in($sellerAware),
            ],
            'add_signer' => [
                'required',
                Rule::in($sellerAware),
            ],
        ];

        if ($this->addendum == config('constant.inverse_common_yes_no.Yes')) {
            $rules += [
                'close_date' => 'required|date',
            ];
        }
        if ($this->set_specific_date == config('constant.inverse_common_yes_no.Yes')) {
            $rules += [
                'date_of_expiry' => 'required|date',
            ];
        }
        if ($this->add_signer == config('constant.inverse_common_yes_no.Yes')) {
            $rules += [
                'select_email.*' => 'required|email',
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
