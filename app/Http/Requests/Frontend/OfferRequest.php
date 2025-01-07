<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class OfferRequest extends Request
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
        $documentArr = ['Pre Qualified', 'Pre Approved', 'Not Approved', 'Cash Buyer'];
        //        $petsArr=[1,2,3];
        $rules = [
            'property_id' => 'required',
            'type' => 'required',
        ];

        // rent
        if ($this->type == config('constant.property_type.1')) {
            $rules += [
                'rent_price' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'lease_term.*' => 'required',
                'date_of_occupancy' => 'required|date',
                'month_count' => 'required',
                'pets_welcome' => 'required',
            ];
            if ($this->pets_welcome == 'Yes') {
                $rules += [
                    'pets_type.*' => 'required',
                ];
                if (isset($this->pets_type['Other']) && $this->pets_type['Other']) {
                    $rules += [
                        'pet_other_explanation' => 'required',
                    ];
                }
            }
        } elseif ($this->type == config('constant.property_type.2')) {      //sale
            $rules += [
                'tentative_offer_price' => 'required',
                'closing_cost_requested' => 'required',
                'any_contingencies' => 'required',
                'qualification_documents' => [
                    'required',
                    Rule::in($documentArr),
                ],
            ];
            if ($this->closing_cost_requested == 'Yes') {
                if (empty($this->percentage_of_price) && empty($this->fixed_amount)) {
                    $rules += [
                        'percentage_of_price' => 'required',
                    ];
                } elseif (empty($this->percentage_of_price) && ! empty($this->fixed_amount)
                    && isset($this->both_amount_filled)) {
                    $rules += [
                        'percentage_of_price' => 'required',
                    ];
                }
            }
            if ($this->any_contingencies == 'Yes') {
                $rules += [
                    'contingencies_explain' => 'required',
                ];
            }
            $rules += [
                'userfile' => 'mimes:pdf,doc,dot,jpg,jpeg,png',
            ];
            if ($this->qualification_documents == 'Cash Buyer') {
                $rules += [
                    'source_of_cash' => 'required',
                ];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [];
        if ($this->type == config('constant.property_type.2')) {
            if (empty($this->percentage_of_price) && ! empty($this->fixed_amount)
                && isset($this->both_amount_filled)) {
                $messages += [
                    'percentage_of_price.required' => 'Please enter either percentage of price or fixed amount.',
                ];
            }
        }

        return $messages;
    }

    public function all($keys = null)
    {
        $data = parent::all();

        if (isset($data['type']) && $data['type'] == config('constant.property_type.2')) {
            if (isset($data['closing_cost_requested']) && $data['closing_cost_requested'] == 'Yes') {

                if (isset($data['percentage_of_price']) && isset($data['fixed_amount']) && ! empty($data['percentage_of_price']) && ! empty($data['fixed_amount'])) {
                    $data['percentage_of_price'] = null;
                    $data['both_amount_filled'] = 'Please enter either percentage of price or fixed amount.';
                }
            }
        }

        return $data;
    }
}
