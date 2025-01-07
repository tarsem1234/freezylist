<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\County;
use App\Models\Property;
use App\Models\PropertyConditionDisclaimer;
use App\Models\School;
use App\Models\State;
use App\Models\VacationProperty;
use App\Models\ZipCode;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Class LanguageController.
 */
class PropertyController extends Controller
{
    /**
     * @param  $lang
     */
    public function rentIndex(): View
    {
        $rents = Property::where('property_type',
            config('constant.inverse_property_type.Rent'))
            ->with(['architechture', 'images', 'additional_information'])->latest()->get();

        return view('backend.rent.index', ['rents' => $rents]);
    }

    public function saleIndex(): View
    {
        $sales = Property::where('property_type',
            config('constant.inverse_property_type.Sale'))
            ->with(['architechture', 'images', 'additional_information'])->latest()->get();
        //        $city    = City::where('id', $sales->city_id)->first();

        return view('backend.sale.index', ['sales' => $sales]);
    }

    public function vacationIndex(): View
    {
        $vacations = VacationProperty::with('images', 'availableWeeks')->latest()->get();

        return view('backend.vacation.index', ['vacations' => $vacations]);
    }

    // Single Page details
    public function saleDetail($id)
    {
        if (! Property::where('id', $id)->where('property_type', config('constant.inverse_property_type.Sale'))->exists()) {
            return redirect()->back()->with('flash_danger', 'Property not found.');
        }
        $details = Property::where('id', $id)->where('property_type',
            config('constant.inverse_property_type.Sale'))
            ->with(['architechture', 'images', 'additional_information' => function ($q) {
                $q->select('additional_information.*',
                    'a_i_2.name as parent_name')->join('additional_information as a_i_2',
                        'a_i_2.id', '=', 'additional_information.parent_id');
            }])->first();
        //        dd($rentDetails);
        $additional_information = $details->additional_information->groupBy('parent_name');

        $state = State::where('id', $details->state_id)->first();
        $county = County::where('id', $details->county_id)->first();
        $city = City::where('id', $details->city_id)->first();
        $zipCode = ZipCode::where('id', $details->zip_code_id)->first();
        $schools = School::whereIn('id', explode(',', $details->architechture->school_id))->get();

        $isPropertyConditionDisclaimer = PropertyConditionDisclaimer::where('property_id', $id)->count();
        $isLeadBasedPaintHazards = Property::where('id', $id)
            ->where('lead_based', '!=', null)
            ->where('lead_based_report', '!=', null)->count();

        return view('backend.sale.details',
            ['details' => $details, 'schools' => $schools, 'state' => $state,
                'county' => $county, 'city' => $city, 'zipCode' => $zipCode, 'additional_information' => $additional_information,
                'isPropertyConditionDisclaimer' => $isPropertyConditionDisclaimer, 'isLeadBasedPaintHazards' => $isLeadBasedPaintHazards]);
    }

    public function rentDetail($id)
    {
        if (! Property::where('id', $id)->where('property_type', config('constant.inverse_property_type.Rent'))->exists()) {
            return redirect()->back()->with('flash_danger', 'Property not found.');
        }
        $details = Property::where('id', $id)->where('property_type',
            config('constant.inverse_property_type.Rent'))
            ->with(['architechture', 'images', 'additional_information' => function ($q) {
                $q->select('additional_information.*',
                    'a_i_2.name as parent_name')->join('additional_information as a_i_2',
                        'a_i_2.id', '=', 'additional_information.parent_id');
            }])->first();
        //        dd($rentDetails);
        $additional_information = $details->additional_information->groupBy('parent_name');

        $state = State::where('id', $details->state_id)->first();
        $county = County::where('id', $details->county_id)->first();
        $city = City::where('id', $details->city_id)->first();
        $zipCode = ZipCode::where('id', $details->zip_code_id)->first();
        $schools = School::whereIn('id', explode(',', $details->architechture->school_id))->get();

        return view('backend.rent.details',
            ['details' => $details, 'schools' => $schools, 'state' => $state,
                'county' => $county, 'city' => $city, 'zipCode' => $zipCode, 'additional_information' => $additional_information]);
    }

    public function vacationDetail($id)
    {
        if (! VacationProperty::where('id', $id)->exists()) {
            return redirect()->back()->with('flash_danger', 'Property not found.');
        }
        $vacationDetails = VacationProperty::where('id', $id)
            ->with('images', 'availableWeeks')->first();
        //        dd($vacationDetails->toArray());

        $state = State::where('id', $vacationDetails->state_id)->first();
        $county = County::where('id', $vacationDetails->county_id)->first();

        return view('backend.vacation.details',
            ['vacationDetails' => $vacationDetails, 'state' => $state,
                'county' => $county]);
    }

    public function destroyRent($id): JsonResponse
    {
        if (Property::where('id', $id)->where('property_type',
            config('constant.inverse_property_type.Rent'))->delete()) {

            return response()->json(['success' => true, 'message' => 'Rent property deleted successfully'],
                200);
        }

        return response()->json(['success' => true, 'message' => 'Rent property Deletion Failed'],
            500);
    }

    public function destroySale($id): JsonResponse
    {
        //        dd($id);
        if (Property::where('id', $id)->where('property_type',
            config('constant.inverse_property_type.Sale'))->delete()) {

            return response()->json(['success' => true, 'message' => 'Sale property deleted successfully'],
                200);
        }

        return response()->json(['success' => true, 'message' => 'Sale property Deletion Failed'],
            500);
    }

    public function destroyVacation($id): JsonResponse
    {
        if (VacationProperty::where('id', $id)->delete()) {

            return response()->json(['success' => true, 'message' => 'Vacation property deleted successfully'],
                200);
        }

        return response()->json(['success' => true, 'message' => 'Vacation property Deletion Failed'],
            500);
    }
}
