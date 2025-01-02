<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PropertyConditionDisclaimerRequest extends Request
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
        $sellerAware = [1, 2, 3];

        $rules = [
            'propertyage' => 'required',
            'date_of_occupancy' => 'required',
            'occupy' => 'required',
            'propertyis' => 'required',
            'rooftype' => 'required',
            'roofage' => 'required',
            'bsknowledge' => 'required',
            'interior_walls' => [
                'required',
                Rule::in($sellerAware),
            ],
            'ceilings' => [
                'required',
                Rule::in($sellerAware),
            ],
            'floors' => [
                'required',
                Rule::in($sellerAware),
            ],
            'windows' => [
                'required',
                Rule::in($sellerAware),
            ],
            'doors' => [
                'required',
                Rule::in($sellerAware),
            ],
            'heat_pump' => [
                'required',
                Rule::in($sellerAware),
            ],
            'central_heating' => [
                'required',
                Rule::in($sellerAware),
            ],
            'sidewalks' => [
                'required',
                Rule::in($sellerAware),
            ],
            'driveway' => [
                'required',
                Rule::in($sellerAware),
            ],
            'slab' => [
                'required',
                Rule::in($sellerAware),
            ],
            'foundation' => [
                'required',
                Rule::in($sellerAware),
            ],
            'basement' => [
                'required',
                Rule::in($sellerAware),
            ],
            'roof' => [
                'required',
                Rule::in($sellerAware),
            ],
            'exterior_walls' => [
                'required',
                Rule::in($sellerAware),
            ],
            'electrical_system' => [
                'required',
                Rule::in($sellerAware),
            ],
            'sewer' => [
                'required',
                Rule::in($sellerAware),
            ],
            'plumbing' => [
                'required',
                Rule::in($sellerAware),
            ],
            'insulation' => [
                'required',
                Rule::in($sellerAware),
            ],
            //            'central_air_conditioning' => 'required',      partb_details check if above yes
            'substances' => [
                'required',
                Rule::in($sellerAware),
            ],
            'features_shared' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_authorized_changes' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_change_since_latest_survey' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_encroachments' => [
                'required',
                Rule::in($sellerAware),
            ],
            'repairs' => [
                'required',
                Rule::in($sellerAware),
            ],
            'repairs_with_building_codes' => [
                'required',
                Rule::in($sellerAware),
            ],
            'landfill' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_settling' => [
                'required',
                Rule::in($sellerAware),
            ],
            'problems' => [
                'required',
                Rule::in($sellerAware),
            ],
            'requirement' => [
                'required',
                Rule::in($sellerAware),
            ],
            'location' => [
                'required',
                Rule::in($sellerAware),
            ],
            'interior' => [
                'required',
                Rule::in($sellerAware),
            ],
            'structural_damage' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_zoning_violations' => [
                'required',
                Rule::in($sellerAware),
            ],
            'neighborhood_noise' => [
                'required',
                Rule::in($sellerAware),
            ],
            'restrictions' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_common_area' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_notices' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_lawsuit' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_system' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_exterior' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_finished_rooms' => [
                'required',
                Rule::in($sellerAware),
            ],
            'any_septic_tank' => [
                'required',
                Rule::in($sellerAware),
            ],
            'affected' => [
                'required',
                Rule::in($sellerAware),
            ],
            'in_an_historical_district' => [
                'required',
                Rule::in($sellerAware),
            ],
            //            'in_an_historical_district' => 'required',     part c condition check if yes
        ];
        //        if ($this->occupy == config('constant.inverse_property_disclaimer_occupy.Seller does not occupy property')) {
        //            $rules += [
        //                'howlong' => 'required',
        //            ];
        //        }
        if ($this->houseowners_associations == config('constant.inverse_common_yes_no.Yes')) {
            $rules += [
                'name_address' => 'required',
                'monthly_dues' => 'required',
                'transfer_fees' => 'required',
                'special_assessments' => 'required',
            ];
        }
        if (isset($this->property_includes['Fireplace']) && ! empty($this->property_includes['Fireplace'])) {
            $rules += [
                'howmany' => 'required',
            ];
        }
        if (isset($this->property_includes['Pool']) && ! empty($this->property_includes['Pool'])) {
            $rules += [
                'pool' => 'required',
            ];
        }
        if (isset($this->property_includes['Garage']) && ! empty($this->property_includes['Garage'])) {
            $rules += [
                'garage' => 'required',
            ];
        }
        if (isset($this->property_includes['Garage Door Opener']) && ! empty($this->property_includes['Garage Door Opener'])) {
            $rules += [
                'how_many_remotes' => 'required',
            ];
        }
        if (isset($this->property_includes['Heat Pump']) && ! empty($this->property_includes['Heat Pump'])) {
            $rules += [
                'heat_pump_age' => 'required',
            ];
        }
        if (isset($this->property_includes['Central Heating']) && ! empty($this->property_includes['Central Heating'])) {
            $rules += [
                'central_heating_age' => 'required',
                'central_heating_type.*' => 'required',
            ];
        }
        if (isset($this->property_includes['Central Air Conditioning']) && ! empty($this->property_includes['Central Air Conditioning'])) {
            $rules += [
                'central_air_conditioning_age' => 'required',
                'central_air_conditioning_type.*' => 'required',
            ];
        }
        if (isset($this->property_includes['Water Heater']) && ! empty($this->property_includes['Water Heater'])) {
            $rules += [
                'water_heater_age' => 'required',
                'water_heater_type.*' => 'required',
            ];
        }
        if (isset($this->property_includes['Water Supply']) && ! empty($this->property_includes['Water Supply'])) {
            $rules += [
                'water_supply_type.*' => 'required',
            ];
        }
        if (isset($this->property_includes['Gas Supply']) && ! empty($this->property_includes['Gas Supply'])) {
            $rules += [
                'gas_supply_type.*' => 'required',
            ];
        }

        if ($this->bsknowledge == config('constant.inverse_common_yes_no.Yes')) {
            $rules += [
                'bsknowledge_explain' => 'required',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
        ];
    }
}
