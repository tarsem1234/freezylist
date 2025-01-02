<?php

namespace App\Http\Requests\Frontend\ContractTools;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveLeadBasedPaintHazardsBuyerContractToolBuyerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'opportunity' => [
                'required',
                Rule::in($epa),
            ],
        ];
    }
}
