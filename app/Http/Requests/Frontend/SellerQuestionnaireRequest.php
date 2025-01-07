<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SellerQuestionnaireRequest extends Request
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
        $yesNoCount = [1, 2];
        $rules = [
            //            'household_items' => 'required',
            'houseowners_associations' => [
                'required',
                Rule::in($yesNoCount),
            ],
            'real_estate_agent' => [
                'required',
                Rule::in($yesNoCount),
            ],
            'add_signer' => [
                'required',
                Rule::in($yesNoCount),
            ],
            'earnest_money' => [
                'required',
                Rule::in($yesNoCount),
            ],
        ];

        if ($this->earnest_money == config('constant.inverse_seller_questionnaire.Yes')) {
            $rules += [
                'amount_for_earnest_money' => 'required',
            ];
        }
        if ($this->real_estate_agent == config('constant.inverse_seller_questionnaire.Yes')) {
            $rules += [
                'real_estate_firm_name' => 'required',
                'commission' => 'required',
                'name' => 'required',
                'phone' => 'required',
            ];
        }
        if ($this->houseowners_associations == config('constant.inverse_seller_questionnaire.Yes')) {
            $rules += [
                'property_vacant_date' => 'required|date',
            ];
        }
        if ($this->joint_cowners == config('constant.inverse_seller_questionnaire.Yes')) {
            $rules += [
                'partner.*' => 'required',
            ];
        }
        if ($this->add_signer == config('constant.inverse_seller_questionnaire.Yes')) {
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
}
