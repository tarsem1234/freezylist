<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;

class QuestionsSellerPostClosingRequest extends Request
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
        if (isset($this->additional_provisions) && ($this->additional_provisions == null || $this->additional_provisions)) {
            $rules = [
                'additional_provisions' => 'required',
            ];

            return $rules;
        }
        $rules = [
            'current_mortgage' => 'required',
            'additional_charge' => 'required',
            'refundable_security' => 'required',
            'unearned_rents' => 'required',
            'utilities' => 'required',
            'renter_policy' => 'required',
            'renter_policy' => 'required',
            'liability_insurance' => 'required',
        ];

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
