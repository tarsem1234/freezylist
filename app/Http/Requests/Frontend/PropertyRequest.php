<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\Request;
use App\Models\PropertyImage;
use App\Models\VacationImage;
use Illuminate\Validation\Rule;

class PropertyRequest extends Request
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
        $rules = [
            'property_type' => 'required',
            'limit' => 'required|integer|between:1,10',
            'price' => 'required',
        ];
        if ($this->property_type == config('constant.property_type.1') || $this->property_type == config('constant.property_type.2')) {
            $rules += [
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'county' => 'required',
                'street_address' => 'required',
                'home_type' => 'required',
                'beds' => 'required',
                'baths' => 'required',
                'home_size' => 'required',
                //                'plotsize' => 'required',
                'description' => 'required',
                'builtyear' => 'required',
                'agree' => 'required',
            ];
            if (isset($this->total_rooms) && $this->total_rooms) {
                $rules += [
                    'total_rooms' => 'required|numeric',
                ];
            }
        }
        if ($this->property_type == config('constant.property_type.3')) {
            $sellerAware = ['Timeshare', 'Owner Property'];
            $rules += [
                'vacation_property_type' => ['required',
                    Rule::in($sellerAware)],
                'resort_name' => 'required|max:191',
                'region' => 'required',
                'subregion' => 'required',
                'country' => 'required',
                'bathrooms' => 'required',
                'bedrooms' => 'required',
                'sleeps' => 'required',
                //                'annual_maintenance_fees' => 'required',
                //                'property_description' => 'required',
            ];
            if ($this->vacation_property_type == config('constant.inverse_vacation_property_type.Timeshare')) {
                $rules += [
                    'point_based_timeshare' => 'required',
                    'lock_out_unit' => 'required',
                    'variable' => 'required',
                    'available_weeks' => 'required',
                    'checkin_day' => 'required',
                ];
            } elseif ($this->vacation_property_type == config('constant.inverse_vacation_property_type.Owner Property')) {
                $rules += [
                    'owner_address' => 'required',
                    'owner_zip' => 'required',
                ];
            }
        }
        if (((count($this->deletedImageIds) - $this->storedImageCount) == 0) && $this->commingImageCount == 0) {
            $rules += [
                'images' => 'required',
            ];
        }
        if ($this->property_submit == 'Update') {
            if (isset($this->images) && ! empty($this->images)) {
                $rules += [
                    'images.*' => 'image|mimes:jpeg,jpg,png,pjpeg,gif|max:2048',
                ];
            }
        } else {
            if (isset($this->images) && ! empty($this->images)) {
                $rules += [
                    'images.*' => 'image|mimes:jpeg,jpg,png,pjpeg,gif|max:2048',
                ];
            } else {
                $rules += [
                    'images' => 'required',
                ];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [];

        return $messages;
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        // echo'<pre>';print_r($data);die;
        $data['limit'] = 0;
        $storedImageCount = 0;
        $commingImageCount = 0;
        $deletedImageIds = [];
        if (isset($data['property_submit']) && $data['property_submit'] == 'Update') {
            if ($data['property_type'] == 'Vacation') {
                $storedImageCount = VacationImage::where('vacation_property_id', $data['property_table_id'])->count();
            } else {
                $storedImageCount = PropertyImage::where('property_id', $data['property_table_id'])->count();
            }
            $commingImageCount = ! empty($data['images']) ? count($data['images']) : 0;
            //                    count($data['images'] ?? 0);

            if ($data['image_ids']) {
                $deletedImageIds = explode(',', $data['image_ids']);
                $totalImages = $storedImageCount - count($deletedImageIds) + $commingImageCount;
            } else {

                $totalImages = $storedImageCount + $commingImageCount;
            }
            if ($totalImages > config('constant.image_count')) {
                $data['limit'] = 11;
            } else {
                $data['limit'] = 1;
            }
            parent::merge(['limit' => $data['limit'], 'storedImageCount' => $storedImageCount,
                'commingImageCount' => $commingImageCount, 'deletedImageIds' => $deletedImageIds]);

            return parent::all();
        }
        if (isset($data['images'])) {
            $data['limit'] = count($data['images'] ?? 0);
        } else {
            $data['limit'] = 1;
        }

        $data['storedImageCount'] = $storedImageCount;
        parent::merge(['limit' => $data['limit'], 'storedImageCount' => $storedImageCount,
            'commingImageCount' => $commingImageCount, 'deletedImageIds' => $deletedImageIds]);

        return parent::all();
    }
}
