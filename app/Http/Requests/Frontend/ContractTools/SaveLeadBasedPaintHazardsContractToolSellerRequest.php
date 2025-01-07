<?php

namespace App\Http\Requests\Frontend\ContractTools;

use Illuminate\Foundation\Http\FormRequest;

class SaveLeadBasedPaintHazardsContractToolSellerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'lead_based' => [
                'required',
            ],
            'lead_based_report' => [
                'required',
            ],
        ];
    }
}
