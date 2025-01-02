<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PropertyRequest;
use App\Http\Requests\Frontend\SearchedRentPropertyRequest;
use App\Http\Requests\Frontend\SearchedSalePropertyRequest;
use App\Mail\AvailabilityConfirmation;
use App\Mail\Frontend\SendMessageToSeller;
use App\Models\AdditionalInformation;
use App\Models\additionalInformationProperty;
use App\Models\City;
use App\Models\Country;
use App\Models\County;
use App\Models\Message;
use App\Models\MilitaryLocation;
use App\Models\NonUsCity;
use App\Models\Property;
use App\Models\PropertyArchitecture;
use App\Models\PropertyAvailability;
use App\Models\PropertyImage;
use App\Models\Region;
use App\Models\RentOffer;
use App\Models\SaleOffer;
use App\Models\School;
use App\Models\SchoolDistrict;
use App\Models\State;
use App\Models\SubRegion;
use App\Models\VacationAvailableCheckin;
use App\Models\VacationImage;
use App\Models\VacationProperty;
use App\Models\ZipCode;
use App\Services\EmailLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/**
 * Class LanguageController.
 */
class PropertyController extends Controller
{
    /**
     * @param  $lang
     */
    private function _forgetOfferSession()
    {
        Session::forget('OFFER');
        Session::forget('PROPERTY');
    }

    public function rentsList(): View
    {
        $properties = Property::where('user_id', Auth::id())
            ->where('property_type', config('constant.inverse_property_type.Rent'))
            ->with(['user', 'architechture', 'images', 'additional_information',
                'propertyConditionDisclaimer', 'rentOffer' => function ($query) {
                    $query->where(function ($offerQuery) {
                        $offerQuery->orWhere('status', config('constant.inverse_offer_status.accepted'))
                            ->orWhere('closed', config('constant.offer_open_close.close'));
                    })->first();
                }])
            ->latest()->paginate(config('conatant.common_pagination'));

        return view('frontend.property.rents_list', ['properties' => $properties]);
    }

    public function salesList(): View
    {
        $this->_forgetOfferSession();
        $properties = Property::where('user_id', Auth::id())
            ->where('property_type', config('constant.inverse_property_type.Sale'))
            ->whereHas('architechture')
            ->with(['user', 'architechture', 'latestImage', 'additional_information',
                'propertyConditionDisclaimer', 'saleOffer' => function ($query) {
                    $query->where(function ($offerQuery) {
                        $offerQuery->orWhere('status', config('constant.inverse_offer_status.accepted'))
                            ->orWhere('closed', config('constant.offer_open_close.close'));
                    })->first();
                }])
            ->latest()
            ->paginate(config('constant.common_pagination'));

        return view('frontend.property.sales_list', ['properties' => $properties]);
    }

    public function vacationsList(): View
    {
        $properties = VacationProperty::where('user_id', Auth::id())
            ->with('images', 'availableWeeks')
            ->latest()
            ->paginate(config('conatant.common_pagination'));

        return view('frontend.property.vacations_list', ['properties' => $properties]);
    }

    public function schoolSearch(Request $request): Response
    {
        $schools = School::where('school_district', $request->district_id)->get();
        $school_ids = $request->school_id;
        if ($schools) {
            $schools = view('properties.append_schools', compact('schools', 'school_ids'))->render();

            return response(['schools' => $schools, 'success' => true]);
        }

        return response(['schools' => '', 'success' => false], 500);
    }

    public function countrySearch(Request $request): Response
    {
        if ($request->region_id || $request->subregion_id || $request->country_id) {

            $countries = Country::where('subregion_id', $request->subregion_id)->get();
            $subregions = SubRegion::where('region_id', $request->region_id)->get();

            $country_id = $request->country_id;
            $subregion_id = $request->subregion_id;

            if ($countries) {
                $countries = view('properties.append_countries', compact('countries', 'country_id'))->render();
                $subregions = view('properties.append_subregions', compact('subregions', 'subregion_id'))->render();

                return response(['countries' => $countries, 'subregions' => $subregions, 'success' => true]);
            }
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    public function stateSearch(Request $request): Response
    {
        if ($request->state_id) {
            $states = State::get();
            $state_id = $request->state_id;

            if ($states) {
                $states = view('properties.append_us_states', compact('states', 'state_id'))->render();

                return response(['states' => $states, 'success' => true]);
            }
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    public function citySearch(Request $request): Response
    {
        if ($request->country_id && ! isset($request->search)) {
            $country = Country::where('id', $request->country_id)->first();
            if ($request->country_id == 227) {
                $cities = City::where('state_id', $request->state_id)->get();
                $usCities = true;
                $city_id = $request->city_id;
                $cities = view('properties.append_cities', compact('cities', 'city_id', 'usCities'))->render();

                return response(['cities' => $cities, 'city_id' => $city_id, 'usCities' => $cities, 'success' => true]);
            } else {
                $cities = NonUsCity::where('city_code', $country->city_code)->get();
                $nonUsCities = true;
                $cityName = $request->city_id;
                $cities = view('properties.append_cities', compact('cities', 'cityName', 'nonUsCities'))->render();

                return response(['cities' => $cities, 'nonUsCities' => $nonUsCities, 'success' => true]);
            }
        } elseif ($request->state_id && isset($request->search) && State::where('id', $request->state_id)->exists()) {
            $usCities = true;
            $cities = City::where('state_id', $request->state_id)->pluck('city', 'id');
            $zipCodes = ZipCode::whereIn('city_id', array_keys($cities->toArray()))->pluck('zipcode', 'id');

            return response(['cities' => $cities, 'zipCodes' => $zipCodes, 'success' => true]);
        } elseif ($request->state_id && ! $request->search && State::where('id', $request->state_id)->exists()) {
            $cities = City::where('state_id', $request->state_id)->pluck('city', 'id');
            $zipCodes = ZipCode::whereIn('city_id', array_keys($cities->toArray()))->pluck('zipcode', 'id');

            return response(['zipCodes' => $zipCodes, 'success' => true]);
        } else {
            return response(['message' => 'Something went wrong.', 'success' => false], 500);
        }
    }

    public function cityCountySearch(Request $request): Response
    {
        if ($request->state_id) {
            $counties = County::where('state_id', $request->state_id)->get();
            $cities = City::where('state_id', $request->state_id)->get();
            $city_id = $request->city_id;
            $county_id = $request->county_id;

            $cities = view('properties.append_cities', compact('cities', 'city_id'))->render();
            $counties = view('properties.append_counties', compact('counties', 'county_id'))->render();

            return response(['cities' => $cities, 'counties' => $counties, 'success' => true]);
        } else {

            return response(['message' => 'Something went wrong.', 'success' => false], 500);
        }
    }

    public function zipSearch(Request $request): Response
    {
        if ($request->city_id) {
            $zipCodes = ZipCode::where('city_id', $request->city_id)->pluck('zipcode', 'id');
            if ($zipCodes) {
                return response(['zipCodes' => $zipCodes, 'success' => true]);
            }
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    public function militaryLocationSearch(Request $request): Response
    {
        if ($request->state_id) {
            $militarylocations = MilitaryLocation::where('state', $request->state)->pluck('base', 'id');
            if ($militarylocations) {
                return response(['militarylocations' => $militarylocations, 'success' => true]);
            }
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    public function getCounties(Request $request): Response
    {
        if ($request->state) {
            $state = State::where('state', $request->state)->first();
            if ($request->county && ! County::where('county', $request->county)->exists() && $state) {
                $newCounty = new County;
                $newCounty->state_id = $state->id;
                $newCounty->county = $request->county;
                $newCounty->save();
            }
            $counties = County::where('state_id', $state->id)->orderBy('county')->pluck('id', 'county');

            return response(['counties' => $counties, 'success' => true]);
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    //get zipcode using state id
    public function getZipCodes(Request $request): Response
    {
        if ($request->state) {
            $state = State::where('state', $request->state)->first();
            //            if ($request->county && !County::where('county', $request->county)->exists() && $state) {
            //                $newCounty = new County();
            //                $newCounty->state_id = $state->id;
            //                $newCounty->county = $request->county;
            //                $newCounty->save();
            //            }
            $zipcodes = ZipCode::where('state_id', $state->id)->orderBy('zipcode')->pluck('id', 'zipcode');

            return response(['zipcodes' => $zipcodes, 'success' => true]);
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    //get cities using state id
    public function getCities(Request $request): Response
    {
        if ($request->state) {
            $state = State::where('state', $request->state)->first();
            //            if ($request->county && !County::where('county', $request->county)->exists() && $state) {
            //                $newCounty = new County();
            //                $newCounty->state_id = $state->id;
            //                $newCounty->county = $request->county;
            //                $newCounty->save();
            //            }
            $cities = City::where('state_id', $state->id)->orderBy('id')->pluck('id', 'city');

            return response(['cities' => $cities, 'success' => true]);
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    public function stateRelatedDataSearch(Request $request): Response
    {
        if ($request->state_id) {
            $findCitiesForZipCode = City::where('state_id', $request->state_id)->pluck('id');

            $cities = City::where('state_id', $request->state_id)->orderBy('city')->pluck('id', 'city');

            $zipCodes = ZipCode::whereIn('city_id', $findCitiesForZipCode)->pluck('zipcode', 'id');
            $militarylocations = MilitaryLocation::where('state_id', $request->state_id)->orderBy('base')->pluck('id', 'base');
            $counties = County::where('state_id', $request->state_id)->orderBy('county')->pluck('id', 'county');
            if ($militarylocations) {
                return response(['militarylocations' => $militarylocations, 'zipCodes' => $zipCodes, 'cities' => $cities, 'counties' => $counties, 'success' => true]);
            }
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    public function schoolDistrict(Request $request): Response
    {
        if ($request->state) {
            $districtId = isset($request->districtId) ? $request->districtId : null;
            $state = State::where('state', $request->state)->first();
            if ($state) {
                $schoolDistricts = SchoolDistrict::where('state_id', $state->id)->get();
                if (count($schoolDistricts) > 0) {
                    $schoolDistrict = view('properties.append_schoolDistrict', compact('schoolDistricts', 'districtId'))->render();

                    return response(['schoolDistrict' => $schoolDistrict, 'success' => true]);
                }

                return response(['message' => 'School District not found.', 'success' => false], 500);
            }

            return response(['message' => 'State not found.', 'success' => false], 500);
        }

        return response(['message' => 'Something went wrong.', 'success' => false], 500);
    }

    public function rentCreate(Request $request)
    {

        if (! $request->has('id') || ($request->has('id') && Property::where('id', $request->id)->where('user_id', Auth::id())->exists())) {
            $states = State::get();
            $cities = [];
            $zipCodes = ZipCode::get();

            if (! $request->id) {
                $counties = null;
                $properties = Property::where('property_type', config('constant.inverse_property_type.Rent'))
                    ->with(['user', 'architechture', 'images', 'additional_information'])
                    ->get();

                $AdditionalInformation = AdditionalInformation::wherehas('children')->with('children')->get();

                return view('properties.rent', compact('zipCodes', 'counties', 'states', 'cities'), ['AdditionalInformation' => $AdditionalInformation]);
            }

            if ($request->type == config('constant.inverse_property_type.1') && $request->id) {		      //rent
                $AdditionalInformation = AdditionalInformation::wherehas('children')->with('children')->get();
                $property = Property::where('id', $request->id)->where('property_type', config('constant.inverse_property_type.Rent'))
                    ->with(['architechture', 'images' => function ($imgQuery) {
                        $imgQuery->latest();
                    }, 'additional_information' => function ($q) {
                        $q->select('additional_information.*', 'a_i_2.name as parent_name')->join('additional_information as a_i_2', 'a_i_2.id', '=', 'additional_information.parent_id');
                    }])->first();
                $additional_information = $property->additional_information->groupBy('parent_name');

                $state = State::where('id', $property->state_id)->first();
                $county = County::where('id', $property->county_id)->first();
                $counties = County::where('state_id', $property->state_id)->orderBy('county')->get();
                $city = City::where('id', $property->city_id)->first();
                $zipCode = ZipCode::where('id', $property->zip_code_id)->first();
                $schools = School::whereIn('id', explode(',', $property->architechture->school_id))->get();

                return view('properties.rent', compact('zipCodes', 'counties', 'states', 'cities'), ['property' => $property, 'schools' => $schools, 'state' => $state,
                    'county' => $county, 'city' => $city, 'zipCode' => $zipCode, 'additional_information' => $additional_information,
                    'AdditionalInformation' => $AdditionalInformation, 'counties' => $counties]);
            }

            return redirect()->back()->with(['flash_warning' => 'Something went wrong.']);
        }

        return redirect()->route('frontend.property.rentsList');
    }

    public function saleCreate(Request $request)
    {
        if (! isset($request->id) || (isset($request->id) && Property::where('id', $request->id)->where('user_id', Auth::id())->exists())) {
            $states = State::get();
            $cities = [];
            $zipCodes = ZipCode::get();
            $counties = County::get();

            if (! $request->id) {
                $AdditionalInformation = AdditionalInformation::wherehas('children')->with('children')->get();

                return view('properties.sale', compact('zipCodes', 'states', 'cities'), ['AdditionalInformation' => $AdditionalInformation]);
            }
            if ($request->type == config('constant.inverse_property_type.2') && $request->id) {
                $AdditionalInformation = AdditionalInformation::wherehas('children')->with('children')->get(); //Sale
                $property = Property::where('id', $request->id)->where('property_type', config('constant.inverse_property_type.Sale'))
                    ->with(['architechture', 'latestImage', 'additional_information' => function ($q) {
                        $q->select('additional_information.*', 'a_i_2.name as parent_name')->join('additional_information as a_i_2', 'a_i_2.id', '=', 'additional_information.parent_id');
                    }])->first();
                $additional_information = $property->additional_information->groupBy('parent_name');

                $state = State::where('id', $property->state_id)->first();
                $county = County::where('id', $property->county_id)->first();
                $counties = County::where('state_id', $property->state_id)->orderBy('county')->get();
                $city = City::where('id', $property->city_id)->first();
                $zipCode = ZipCode::where('id', $property->zip_code_id)->first();
                $school = School::where('id', $property->architechture->school_id)->first();

                return view('properties.sale', compact('zipCodes', 'counties', 'states', 'cities'), ['property' => $property, 'school' => $school, 'state' => $state,
                    'county' => $county, 'city' => $city, 'zipCode' => $zipCode, 'AdditionalInformation' => $AdditionalInformation,
                    'additional_information' => $additional_information, 'counties' => $counties]);
            }
        }

        return redirect()->route('frontend.property.salesList');
    }

    public function vacationCreate(Request $request)
    {
        if (! isset($request->id) || (isset($request->id) && VacationProperty::where('id', $request->id)->where('user_id', Auth::id())->exists())) {
            $states = State::get();
            $cities = [];
            $regions = Region::get();
            $subRegions = SubRegion::get();
            $countries = Country::get();
            if (! $request->id) {

                return view('properties.vacation', compact('regions', 'subRegions', 'countries', 'states', 'cities'));
            }

            $property = VacationProperty::where('id', $request->id)->with('images', 'availableWeeks')->first();
            if ($property) {
                $state = State::where('id', $property->state_id)->first();
                $region = Region::where('id', $property->region_id)->first();
                $subRegion = SubRegion::where('id', $property->subregion_id)->first();
                $country = Country::where('id', $property->country_id)->first();

                return view('properties.vacation', compact('regions', 'subRegions', 'countries', 'states', 'cities'), ['property' => $property, 'region' => $region, 'state' => $state,
                    'subRegion' => $subRegion, 'country' => $country]);
            }

            return view('properties.vacation', compact('regions', 'subRegions', 'countries', 'states', 'cities'));
        }

        return redirect()->route('frontend.property.vacationsList');
    }

    //Store property
    public function propertyStore(PropertyRequest $request): RedirectResponse
    {
        $data = $request->all();
        //Store Rent and Sale
        if ($request->property_type == config('constant.property_type.1') || $request->property_type == config('constant.property_type.2')) {

            $address = $this->_propertyAddress($data);
            if ($request->school_district) {
                $isSchoolDistrict = SchoolDistrict::where('id', $data['school_district'])->first();
                if (! $isSchoolDistrict) {
                    return redirect()->route('frontend.rentCreate')->with('flash_danger', 'SchoolDistrict not found.');
                }
            }
            if ($request->school) {
                $isSchool = School::whereIn('id', $data['school'])->first();
                if (! $isSchool) {
                    return redirect()->route('frontend.rentCreate')->with('flash_danger', 'School not found.');
                }
            }

            $property = new Property;

            //            if ($request->property_type == config('constant.property_type.1')) {        //For Remt
            //                $property->pets = config('constant.inverse_pets_welcome.' . $data['pets_welcome']);
            //            }
            if ($request->property_type == config('constant.property_type.1')) {
                $property->lease_term = ! empty($data['lease_term']) ? implode(', ', $data['lease_term']) : '';
            }
            $property->pets = ! empty($data['pets_welcome']) ? $data['pets_welcome'] : '';
            $property->property_name = ! empty($data['property_id']) ? $data['property_id'] : '';
            $property->state_id = $address['state_id'];
            $property->user_id = Auth::id();
            $property->property_type = config('constant.inverse_property_type.'.$data['property_type']);
            $property->city_id = $address['city_id'];
            $property->county_id = $address['county_id'];
            $property->zip_code_id = $address['zip_code_id'];
            $property->townhouse_apt = $data['townhouse'];
            $property->street_address = $data['street_address'];
            $property->price = $data['price'];
            $property->virtual_tour_url = $data['vturl'];
            $property->latitude = $data['latitude'];
            $property->longitude = $data['longitude'];

            if (isset($data['display_phone'])) {
                $property->display_phone = config('constant.inverse_display_phone.'.$data['display_phone']);
            } else {
                $property->display_phone = config('constant.inverse_display_phone.No');
            }
            $property->agree = config('constant.inverse_agree.'.$data['agree']);
            $property->status = config('constant.inverse_property_status.Available');
            if ($property->save()) {
                //end property
                // store property images
                if (isset($request->images)) {
                    foreach ($request->images as $img) {
                        $imageWithRatio = fixImageRatio($img);
                        $imageName = image_store($img, $imageWithRatio, $property->id);

                        $propertyImage = new PropertyImage;
                        $propertyImage->property_id = $property->id;
                        $propertyImage->image = $imageName;
                        $propertyImage->save();
                    }
                }
                // save property Architecture
                $propertyArchitecture = new PropertyArchitecture;
                $propertyArchitecture->property_id = $property->id;
                if ($request->school_district) {
                    $propertyArchitecture->school_district_id = $isSchoolDistrict->id;
                }
                if ($request->school) {
                    $propertyArchitecture->school_id = implode(',', $data['school']);
                }
                $propertyArchitecture->home_type = config('constant.inverse_home_type.'.$data['home_type']);
                $propertyArchitecture->beds = $data['beds'];
                $propertyArchitecture->baths = $data['baths'];
                $propertyArchitecture->plot_size = $data['lotsizeacre'];
                $propertyArchitecture->home_size = $data['home_size'];
                $propertyArchitecture->describe_your_home = $data['description'];
                $propertyArchitecture->year_built = $data['builtyear'];
                $propertyArchitecture->year_updated = $data['updatedyear'];
                $propertyArchitecture->HOA_dues = $data['hoadues'];
                $propertyArchitecture->total_rooms = $data['total_rooms'];
                $propertyArchitecture->stories = $data['no_of_stories'];
                //              $propertyArchitecture->basement = config('constant.inverse_basement.' . $data['basement']);
                $propertyArchitecture->basement = ! empty($data['basement']) ? $data['basement'] : '';
                $propertyArchitecture->garage_capacity = $data['capacity_of_garage'];
                $propertyArchitecture->additional_features = $data['additional_features'];

                if ($propertyArchitecture->save()) {

                    // save additional informaion
                    if (isset($data['additional_information'])) {

                        foreach ($data['additional_information'] as $information) {

                            $additionalInfo = new additionalInformationProperty;
                            $additionalInfo->additional_information_id = $information;
                            $additionalInfo->property_id = $property->id;
                            if ($additionalInfo->save()) {

                            }
                        }
                    }
                    if ($request->property_type == config('constant.property_type.1')) {

                        return redirect()->route('frontend.property.rentsList')->with('flash_success', 'Property saved successfully.');
                    }

                    return redirect()->route('frontend.property.salesList')->with('flash_success', 'Property saved successfully.');
                }
            } else {

                return redirect()->back()->with('flash_danger', 'property not saved.');
            }
        } elseif ($request->property_type == config('constant.property_type.3')) {	      //store vacation property
            $isUsCity = null;
            $isNonUsCity = null;
            if (isset($data['state']) && $data['state']) {
                $isState = State::where('id', $data['state'])->first();
            }
            if (isset($data['city']) && $data['city']) {
                $isUsCity = City::where('id', $data['city'])->first();
                $isNonUsCity = NonUsCity::where('id', $data['city'])->first();
            }
            $isCountry = Country::where('id', $data['country'])->first();
            $isRegion = Region::where('id', $data['region'])->first();
            $isSubRegion = SubRegion::where('id', $data['subregion'])->first();

            if (isset($data['state']) && ! $isState) {
                return redirect()->route('frontend.vacationCreate')->with('flash_danger', 'State not found.');
            }
            if (! $isCountry) {
                return redirect()->route('frontend.vacationCreate')->with('flash_danger', 'County not found.');
            }
            if (! $isRegion) {
                return redirect()->route('frontend.vacationCreate')->with('flash_danger', 'Region not found.');
            }
            if (! $isSubRegion) {
                return redirect()->route('frontend.vacationCreate')->with('flash_danger', 'Subregion not found.');
            }
            $vacationProperty = new VacationProperty;

            if (isset($isState)) {
                $vacationProperty->state_id = $isState->id;
            }
            if ($request->owner_address) {
                $vacationProperty->address = $request->owner_address;
            }
            if ($request->owner_zip) {
                $vacationProperty->zip_code = $request->owner_zip;
            }
            if ($isUsCity) {
                $vacationProperty->city = $isUsCity->id;
            }
            if ($isNonUsCity) {
                $vacationProperty->city = $isNonUsCity->id;
            }
            $vacationProperty->country_id = $isCountry->id;
            $vacationProperty->user_id = Auth::id();
            $vacationProperty->property_type = config('constant.inverse_vacation_property_type.'.$data['vacation_property_type']);
            $vacationProperty->property_name = $data['resort_name'];
            $vacationProperty->property_web_link = $data['propWebLink'];
            $vacationProperty->region_id = $isRegion->id;
            $vacationProperty->subregion_id = $isSubRegion->id;
            $vacationProperty->point_based_timeshare = config('constant.inverse_point_based_timeshare.'.$data['point_based_timeshare']);
            $vacationProperty->points = $data['points'];
            $vacationProperty->lock_out_unit = config('constant.inverse_lock_out_unit.'.$data['lock_out_unit']);
            $vacationProperty->variable = config('constant.inverse_variable.'.$data['variable']);
            $vacationProperty->exchange_timeshare = config('constant.inverse_exchange_timeshare.'.$data['exchange_timeshare']);
            $vacationProperty->locations = $data['locations'];
            $vacationProperty->bathrooms = $data['bathrooms'];
            $vacationProperty->bedrooms = $data['bedrooms'];
            $vacationProperty->sleeps = $data['sleeps'];
            $vacationProperty->price = $data['price'];
            $vacationProperty->rental_price_negotiable = config('constant.inverse_rental_price_negotiable.'.$data['rental_price_negotiable']);
            $vacationProperty->property_description = $data['property_description'];
            $vacationProperty->ownership_type = $data['ownership_type'];
            $vacationProperty->is_available_for_sale = config('constant.inverse_is_available_for_sale.'.$data['is_available_for_sale']);
            $vacationProperty->sale_price = $data['sale_price'];
            $vacationProperty->lease_expire_year = $data['lease_expire_year'];
            $vacationProperty->how_many_points = $data['how_many_points'];
            $vacationProperty->annual_maintenance_fees = $data['annual_maintenance_fees'];
            $vacationProperty->status = config('constant.inverse_property_status.Available');
            $vacationProperty->latitude = $data['latitude'];
            $vacationProperty->longitude = $data['longitude'];

            if ($vacationProperty->save()) {
                if ($request->images) {			 //store vacation images
                    foreach ($request->images as $img) {
                        $imageWithRatio = fixImageRatio($img);
                        $imageName = image_store($img, $imageWithRatio, $vacationProperty->id);

                        $vacationImage = new VacationImage;
                        $vacationImage->vacation_property_id = $vacationProperty->id;
                        $vacationImage->image = $imageName;
                        if ($vacationImage->save()) {

                            $available_weeks = $data['available_weeks'];
                            $weeks = explode(',', $available_weeks);
                            foreach ($weeks as $week) {
                                $vacationCheckin = new VacationAvailableCheckin;

                                $vacationCheckin->vacation_property_id = $vacationProperty->id;
                                $vacationCheckin->available_week = $week;
                                $vacationCheckin->checkin_day = $data['checkin_day'];
                                $vacationCheckin->save();
                            }

                            return redirect()->route('frontend.property.vacationsList')->with('flash_success', 'Vacation property saved successfully.');
                        }
                    }
                }
            } else {

                return redirect()->route('frontend.vacationCreate')->with('flash_danger', 'Vacation property not saved.');
            }
        } else {

            return redirect()->back()->with('flash_danger', 'Please select valid property.');
        }
    }

    // Updating a property sale/rent
    public function propertyUpdate(PropertyRequest $request): RedirectResponse
    {
        $data = $request->all();
        if ($request->images) {
            $storedImageCount = PropertyImage::where('property_id',
                $data['property_table_id'])->count();
            $commingImageCount = count($request->images);
            $totalImages = $storedImageCount + $commingImageCount;
            if ($totalImages >= 10) {
                return redirect()->back()->with('flash_danger',
                    'Images count is greater then 15.');
            }
        }

        if ($data['property_submit'] && $data['property_table_id'] && $data['property_architecture_table_id']) {

            $address = $this->_propertyAddress($data);
            if ($request->school_district) {
                $isSchoolDistrict = SchoolDistrict::where('id',
                    $data['school_district'])->first();
                if (! $isSchoolDistrict) {
                    return redirect()->back()->with('flash_danger',
                        'SchoolDistrict not found.');
                }
            }
            if ($request->school) {
                $isSchool = School::whereIn('id', $data['school'])->first();
                if (! $isSchool) {
                    return redirect()->back()->with('flash_danger',
                        'School not found.');
                }
            }

            //            if ($request->property_type == config('constant.property_type.1')) {
            //                $input['pets'] = config('constant.inverse_pets_welcome.' . $data['pets_welcome']);
            $input['pets'] = ! empty($data['pets_welcome']) ? $data['pets_welcome'] : 0;
            //            }
            if ($request->property_type == config('constant.property_type.1')) {
                $input['lease_term'] = ! empty($data['lease_term']) ? implode(', ',
                    $data['lease_term']) : '';
            }

            $input['property_name'] = ! empty($data['property_id']) ? $data['property_id'] : '';
            $input['state_id'] = $address['state_id'];
            $input['user_id'] = Auth::id();
            $input['property_type'] = config('constant.inverse_property_type.'.$data['property_type']);
            $input['city_id'] = $address['city_id'];
            $input['county_id'] = $address['county_id'];
            $input['zip_code_id'] = $address['zip_code_id'];
            $input['townhouse_apt'] = $data['townhouse'];
            $input['street_address'] = $data['street_address'];
            $input['price'] = $data['price'];
            $input['virtual_tour_url'] = $data['vturl'];
            if (isset($data['display_phone'])) {
                $input['display_phone'] = config('constant.inverse_display_phone.'.$data['display_phone']);
            } else {
                $input['display_phone'] = config('constant.inverse_display_phone.No');
            }
            $input['agree'] = config('constant.inverse_agree.'.$data['agree']);
            // dd($input);
            if (Property::where('id', $data['property_table_id'])->where('user_id', Auth::id())->update($input)) {

                if (isset($request->image_ids) && $request->image_ids) {
                    $deletedImageIds = explode(',', $request->image_ids);
                    $deletedImages = PropertyImage::whereIn('id',
                        $deletedImageIds)->where('property_id',
                            $data['property_table_id'])->get();
                    foreach ($deletedImages as $delete) {
                        if (File::delete(storage_path(config('constant.property_image_path').'/'.$data['property_table_id'].'/'.$delete->image))) {
                            PropertyImage::where('id', $delete->id)->forceDelete();
                        }
                    }
                }

                if ($request->images) {
                    foreach ($request->images as $img) {
                        $imageWithRatio = fixImageRatio($img);
                        $imageName = image_store($img, $imageWithRatio,
                            $data['property_table_id']);

                        $propertyImage = new PropertyImage;
                        $propertyImage->property_id = $data['property_table_id'];
                        $propertyImage->image = $imageName;
                        $propertyImage->save();
                    }
                }
                $architectureInput['property_id'] = $data['property_table_id'];
                if ($request->school_district) {
                    $architectureInput['school_district_id'] = $request->school_district;
                }
                if ($request->school) {
                    $architectureInput['school_id'] = implode(',',
                        $data['school']);
                } else {
                    $architectureInput['school_id'] = $request->school;
                }
                $architectureInput['home_type'] = config('constant.inverse_home_type.'.$data['home_type']);
                $architectureInput['beds'] = $data['beds'];
                $architectureInput['baths'] = $data['baths'];
                $architectureInput['plot_size'] = $data['lotsizeacre'];
                $architectureInput['home_size'] = $data['home_size'];
                $architectureInput['describe_your_home'] = $data['description'];
                $architectureInput['year_built'] = $data['builtyear'];
                $architectureInput['year_updated'] = $data['updatedyear'];
                $architectureInput['HOA_dues'] = $data['hoadues'];
                $architectureInput['total_rooms'] = $data['total_rooms'];
                $architectureInput['stories'] = $data['no_of_stories'];
                if (isset($data['basement'])) {
                    $architectureInput['basement'] = config('constant.inverse_basement.'.$data['basement']);
                    // $architectureInput['basement'] = $data['basement'];
                }
                $architectureInput['garage_capacity'] = $data['capacity_of_garage'];
                $architectureInput['additional_features'] = $data['additional_features'];

                if (PropertyArchitecture::where('id', $data['property_architecture_table_id'])->where('property_id', $data['property_table_id'])->update($architectureInput)) {

                    if (isset($data['additional_information'])) {
                        additionalInformationProperty::where('property_id',
                            $data['property_table_id'])->forcedelete();

                        foreach ($data['additional_information'] as $information) {
                            $additionalInfo = new additionalInformationProperty;
                            $additionalInfo->additional_information_id = $information;
                            $additionalInfo->property_id = $data['property_table_id'];
                            $additionalInfo->save();
                        }
                    }
                }
                if ($data['property_type'] == config('constant.property_type.1')) {

                    return redirect()->route('frontend.property.rentsList')->with('flash_success',
                        'Property updated successfully.');
                }
                if ($data['property_type'] == config('constant.property_type.2')) {

                    return redirect()->route('frontend.property.salesList')->with('flash_success',
                        'Property updated successfully.');
                }
            } else {
                return redirect()->route('frontend.saleCreate')->with('flash_danger',
                    'property not updated.');
            }
        }
    }

    /*
     * Function Name:_propertyAddress
     * Updated by: Charu Anand 12-june-2019
     * Desc:- Remove saving state,city,county as client has updated the database so no need to save the new onces entries
     */

    private function _propertyAddress($data)
    {
        $state = State::where('state', $data['state'])->first(['id']);

        //Patterns are created as we face problem with the city while getting from google api some cities exist in database with minor changes like -,_ etc in name so we have created the pattern for matching

        $cityPattern1 = str_replace(' ', '_', $data['city']);
        $cityPattern2 = str_replace(' ', '-', $data['city']);
        $cityPattern3 = str_replace('', '-', strtolower($data['city']));
        $city = City::where('state_id', $state->id)
            ->where(function ($query) use ($data, $cityPattern1, $cityPattern2, $cityPattern3) {
                $query->where('city', $data['city'])
                    ->orWhere('id', $data['city'])
                    ->orWhere('city', $cityPattern1)
                    ->orWhere('city', $cityPattern2)
                    ->orWhere('city', $cityPattern3);
            })->first();
        $county = County::where('id', $data['county'])->where('state_id', $state->id)->first();

        $zipCode = ZipCode::where('zipcode', $data['zip'])->where('state_id', $state->id)->first();

        if (empty($zipCode)) {

            $zipCode = new ZipCode;
            $zipCode->city_id = $city->id;
            $zipCode->state_id = $state->id;

            $zipCode->zipcode = $data['zip'];
            $zipCode->type = 'PO BOX';
            //updating zip code in DB which actually start with 0 in real but not the same case in present database for us cities
            $zipCode->latitude = $data['latitude'];
            $zipCode->longitude = $data['longitude'];
            $zipCode->save();
        }
        //        else if (!empty($zipCode) && $zipCode->updated_at == "0000-00-00 00:00:00") {
        //            //updating lat long in DB to make sure they are correct in preent DB
        //            $zipCode->latitude = $data['latitude'];
        //            $zipCode->longitude = $data['longitude'];
        //            $zipCode->save();
        //        }

        return [
            'state_id' => $state->id,
            'city_id' => ! empty($city->id) ? $city->id : '',
            'county_id' => $county->id,
            'zip_code_id' => $zipCode->id,
        ];
    }

    public function vacationUpdate(PropertyRequest $request): RedirectResponse
    {

        $data = $request->all();
        //        dd($data);die;
        if ($request->images) {
            $storedImageCount = VacationImage::where('vacation_property_id',
                $request->property_id)->count();
            $commingImageCount = count($request->images);
            $totalImages = $storedImageCount + $commingImageCount;
            if ($totalImages >= 15) {
                return redirect()->back()->with('flash_danger',
                    'Images count is greater then 15.');
            }
        }
        if ($request->state) {
            $isState = State::where('id', $data['state'])->first();
            if (! $isState) {
                return redirect()->back()->with('flash_danger',
                    'State not found.');
            }
        }
        if (isset($data['city']) && $data['city']) {
            $isUsCity = City::where('id', $data['city'])->first();
            $isNonUsCity = NonUsCity::where('id', $data['city'])->first();
        }
        $isCountry = Country::where('id', $data['country'])->first();
        $isRegion = Region::where('id', $data['region'])->first();
        $isSubRegion = SubRegion::where('id', $data['subregion'])->first();
        if (isset($isUsCity) && ! $isUsCity) {
            return redirect()->route('frontend.vacationCreate')->with('flash_danger',
                'City not found.');
        }
        if (isset($isNonUsCity) && ! $isNonUsCity) {
            return redirect()->back()->with('flash_danger', 'City not found.');
        }
        if (! $isCountry) {
            return redirect()->back()->with('flash_danger', 'County not found.');
        }
        if (! $isRegion) {
            return redirect()->back()->with('flash_danger', 'Region not found.');
        }
        if (! $isSubRegion) {
            return redirect()->back()->with('flash_danger',
                'Subregion not found.');
        }

        //        dump($isUsCity);
        //        dump($isNonUsCity);die;
        $ifExists = VacationProperty::where('id', $data['property_id'])->where('user_id',
            Auth::id())->first();

        if ($data['property_submit'] && $data['property_id'] && $ifExists) {
            if (isset($isState)) {
                $input['state_id'] = $isState->id;
            }
            if (isset($isUsCity)) {
                $input['city'] = $isUsCity->id;
            } elseif (isset($isNonUsCity)) {
                $input['city'] = $isNonUsCity->id;
            } else {
                $input['city'] = null;
            }

            $input['country_id'] = $isCountry->id;
            $input['property_name'] = $data['resort_name'];
            $input['property_type'] = config('constant.inverse_vacation_property_type.'.$data['vacation_property_type']);
            $input['region_id'] = $isRegion->id;
            $input['subregion_id'] = $isSubRegion->id;
            $input['zip_code'] = $data['owner_zip'];
            $input['address'] = $data['owner_address'];

            $input['property_web_link'] = $data['propWebLink'];
            //Only update if timeshare property type  has selected

            if ($data['vacation_property_type'] != 'Owner Property') {
                $input['zip_code'] = null;
                $input['address'] = null;
                $input['point_based_timeshare'] = ! empty($data['point_based_timeshare']) ? config('constant.inverse_point_based_timeshare.'.$data['point_based_timeshare']) : '';
                $input['lock_out_unit'] = ! empty($data['lock_out_unit']) ? config('constant.inverse_lock_out_unit.'.$data['lock_out_unit']) : '';
                $input['variable'] = ! empty($data['variable']) ? config('constant.inverse_variable.'.$data['variable']) : '';
                $input['exchange_timeshare'] = ! empty($data['exchange_timeshare']) ? config('constant.inverse_exchange_timeshare.'.$data['exchange_timeshare']) : '';
                $input['locations'] = $data['locations'];
                $input['points'] = $data['points'];
                $input['is_available_for_sale'] = ! empty($data['is_available_for_sale']) ? config('constant.inverse_is_available_for_sale.'.$data['is_available_for_sale']) : '';
                $input['ownership_type'] = ! empty($data['ownership_type']) ? $data['ownership_type'] : '';
                $input['sale_price'] = $data['sale_price'];
                $input['lease_expire_year'] = $data['lease_expire_year'];
                $input['how_many_points'] = $data['how_many_points'];
                $input['annual_maintenance_fees'] = $data['annual_maintenance_fees'];
            } else {
                $input['point_based_timeshare'] = null;
                $input['lock_out_unit'] = null;
                $input['variable'] = null;
                $input['exchange_timeshare'] = null;
                $input['locations'] = null;
                $input['points'] = null;
                $input['is_available_for_sale'] = null;
                $input['ownership_type'] = null;
                $input['sale_price'] = null;

                $input['lease_expire_year'] = null;
                $input['how_many_points'] = null;
                $input['annual_maintenance_fees'] = null;
            }

            $input['bathrooms'] = $data['bathrooms'];
            $input['bedrooms'] = $data['bedrooms'];
            $input['sleeps'] = $data['sleeps'];
            $input['price'] = $data['price'];

            $input['rental_price_negotiable'] = ! empty($data['rental_price_negotiable']) ? config('constant.inverse_rental_price_negotiable.'.$data['rental_price_negotiable']) : '';
            $input['property_description'] = ! empty($data['property_description']) ? $data['property_description'] : '';

            if (VacationProperty::where('id', $data['property_id'])->where('user_id',
                Auth::id())->update($input)) {
                if (isset($request->image_ids) && $request->image_ids) {
                    $deletedImageIds = explode(',', $request->image_ids);
                    $deletedImages = VacationImage::whereIn('id',
                        $deletedImageIds)->where('vacation_property_id',
                            $data['property_table_id'])->get();
                    foreach ($deletedImages as $delete) {
                        if (File::delete(storage_path(config('constant.property_image_path').'/'.$data['property_table_id'].'/'.$delete->image))) {
                            VacationImage::where('id', $delete->id)->forceDelete();
                        }
                    }
                }
                if ($request->images) {    //store vacation images
                    foreach ($request->images as $img) {
                        $imageWithRatio = fixImageRatio($img);
                        $imageName = image_store($img, $imageWithRatio,
                            $request->property_id);

                        $vacationImage = new VacationImage;
                        $vacationImage->vacation_property_id = $data['property_id'];
                        $vacationImage->image = $imageName;
                        $vacationImage->save();
                    }
                }
                if ($data['vacation_property_type'] != 'Owner Property') {
                    VacationAvailableCheckin::where('vacation_property_id',
                        $data['property_id'])->forcedelete();
                    $available_weeks = $data['available_weeks'];
                    $weeks = explode(',', $available_weeks);
                    foreach ($weeks as $week) {
                        $vacationCheckin = new VacationAvailableCheckin;

                        $vacationCheckin->vacation_property_id = $data['property_id'];
                        $vacationCheckin->available_week = ! empty($week) ? $week : '';
                        $vacationCheckin->checkin_day = ! empty($data['checkin_day']) ? $data['checkin_day'] : '';
                        $vacationCheckin->save();
                    }
                } else {
                    VacationAvailableCheckin::where('vacation_property_id',
                        $data['property_id'])->forcedelete();
                }

                return redirect()->route('frontend.property.vacationsList')->with('flash_success',
                    'Vacation property saved successfully.');
            }
        } else {

            return redirect()->route('frontend.vacationCreate')->with('flash_danger',
                'Vacation property not saved.');
        }

        return redirect()->back();
    }

    public function salesHome(): View
    {
        $saleProperties = Property::where('property_type', config('constant.inverse_property_type.Sale'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')->from('users');
                $query->where('status', 1);
                $query->whereNull('deleted_at');
            })->where('status', '=', config('constant.inverse_property_status.Available'))
            ->with('architechture', 'images')
            ->latest()
            ->limit(4)
            ->get();
        $rentProperties = Property::where('property_type', config('constant.inverse_property_type.Rent'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')->from('users');
                $query->where('status', 1);
                $query->whereNull('deleted_at');
            })
            ->where('status', '=', config('constant.inverse_property_status.Available'))
            ->with('architechture', 'images')
            ->latest()
            ->limit(4)
            ->get();
        $vacationProperties = VacationProperty::whereIn('user_id', function ($query) {
            $query->select('id')->from('users');
            $query->where('status', 1);
            $query->whereNull('deleted_at');
        })
            ->latest()
            ->limit(4)
            ->get();

        return view('frontend.property.sales_home', compact('vacationProperties', 'rentProperties', 'saleProperties'));
    }

    public function rentsHome(): View
    {
        $saleProperties = Property::where('property_type', config('constant.inverse_property_type.Sale'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')->from('users');
                $query->where('status', 1);
                $query->whereNull('deleted_at');
            })
            ->where('status', '=', config('constant.inverse_property_status.Available'))
            ->with('architechture', 'images')
            ->latest()
            ->limit(4)
            ->get();
        $rentProperties = Property::where('property_type', config('constant.inverse_property_type.Rent'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')->from('users');
                $query->where('status', 1);
                $query->whereNull('deleted_at');
            })
            ->where('status', '=', config('constant.inverse_property_status.Available'))
            ->with('architechture', 'images')
            ->latest()
            ->limit(4)
            ->get();
        $vacationProperties = VacationProperty::whereIn('user_id', function ($query) {
            $query->select('id')->from('users');
            $query->where('status', 1);
            $query->whereNull('deleted_at');
        })
            ->latest()
            ->limit(4)
            ->get();

        return view('frontend.property.rents_home', compact('vacationProperties', 'rentProperties', 'saleProperties'));
    }

    public function vacationsHome(): View
    {
        $saleProperties = Property::where('property_type', config('constant.inverse_property_type.Sale'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')->from('users');
                $query->where('status', 1);
                $query->whereNull('deleted_at');
            })
            ->with('architechture', 'images')
            ->latest()
            ->limit(4)
            ->get();
        $rentProperties = Property::where('property_type', config('constant.inverse_property_type.Rent'))
            ->whereIn('user_id', function ($query) {
                $query->select('id')->from('users');
                $query->where('status', 1);
                $query->whereNull('deleted_at');
            })
            ->with('architechture', 'images')
            ->latest()
            ->limit(4)
            ->get();
        $vacationProperties = VacationProperty::whereIn('user_id', function ($query) {
            $query->select('id')->from('users');
            $query->where('status', 1);
            $query->whereNull('deleted_at');
        })
            ->latest()
            ->with('images')
            ->limit(4)
            ->get();

        return view('frontend.property.vacations_home', compact('vacationProperties', 'rentProperties', 'saleProperties'));
    }

    public function rentSearch(): View
    {
        $states = State::get();

        return view('frontend.property.rent_search_view', compact('states'));
    }

    public function saleSearch(): View
    {
        $states = State::get();

        return view('frontend.property.sale_search_view', compact('states'));
    }

    public function searchedSale(SearchedSalePropertyRequest $request)
    {

        return $this->_searchedProperty($request);
    }

    public function searchedRent(SearchedRentPropertyRequest $request)
    {

        return $this->_searchedProperty($request);
    }

    /*
     *  Function Name:-_searchedProperty
     *  Updated Desc:- show default lat and long if property not exist but if should focus on that particualar state
     *  Updated by: Charu Anand 20-6-2019
     */

    private function _searchedProperty($request)
    {
        $data = $request->all();
        $states = State::get();
        //        dd($data);
        //        get latitude and longitude for displaying
        $rent = false;
        $sale = false;

        if ($request->type == config('constant.property_type.1')) {
            $rent = true;
        } else {
            $sale = true;
        }

        $latitude = null;
        $longitude = null;

        if (! empty($request->zip)) {
            $zipCode = ZipCode::where('id', $request->zip)->select('id', 'latitude', 'longitude')->first();
            if (! $zipCode) {
                if ($rent) {
                    return view('frontend.property.rent_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
                }

                return view('frontend.property.sale_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
            }

            $latitude = $zipCode->latitude;
            $longitude = $zipCode->longitude;
        } elseif ($request->city) {
            $city = City::where('id', $request->city)->select('id', 'Lat', 'Lng')->first();
            if (! $city) {
                if ($rent) {
                    return view('frontend.property.rent_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
                }

                return view('frontend.property.sale_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
            }

            $latitude = $city->Lat;
            $longitude = $city->Lng;
        } elseif ($request->military_location) {
            $militaryBase = MilitaryLocation::where('id', $request->military_location)->first();
            if (! $militaryBase) {
                if ($rent) {
                    return view('frontend.property.rent_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
                }

                return view('frontend.property.sale_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
            }

            $latitude = $militaryBase->lat;
            $longitude = $militaryBase->lng;
        } elseif ($request->county) {
            $county = County::where('id', $request->county)->first();
            if (! $county) {
                if ($rent) {
                    return view('frontend.property.rent_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
                }

                return view('frontend.property.sale_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
            }
            $latitude = $county->lat;
            $longitude = $county->lng;
        } else {
            $state = State::where('id', $data['state'])->first();
            if (! $state) {
                if ($rent) {
                    return view('frontend.property.rent_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
                }

                return view('frontend.property.sale_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
            }
            $latitude = $state->latitude;
            $longitude = $state->longitude;
        }

        if ($latitude && $longitude) {
            $haversine = "(3958 * acos(cos(radians($latitude)) * cos(radians(latitude))
                    * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude))
                    * sin(radians(latitude))))";
        }

        if ($request->type == config('constant.property_type.1')) {
            $search = Property::where('property_type', config('constant.inverse_property_type.Rent'));
        } else {
            $search = Property::where('property_type', config('constant.inverse_property_type.Sale'));
        }
        $search->where('status', config('constant.inverse_property_status.Available'))->whereHas('user');

        if ($request->state) {
            $search->where('state_id', $request->state);
        }

        if ($request->zip && ! $request->radius) {
            $search->where('zip_code_id', $request->zip);
        } elseif ($request->zip && $request->radius) {
            //
            $search->selectRaw("id,street_address,price,lease_term,townhouse_apt,state_id,property_type,latitude,longitude, {$haversine} AS distance")
                ->whereRaw("{$haversine} < ?", [$request->radius]);
        } elseif ($request->city && ! $request->radius) {
            $search->where('city_id', $request->city);
        } elseif ($request->city && $request->radius) {
            $search->selectRaw("id,street_address,price,lease_term,townhouse_apt,state_id,property_type,latitude,longitude, {$haversine} AS distance")
                ->whereRaw("{$haversine} < ?", [$request->radius]);
        }

        if ($request->military_location && ! $request->radius) {
            $search->where('zip_code_id', $militaryBase->zipcode_id);
        } elseif ($request->military_location && $request->radius) {
            $search->selectRaw("id,street_address,price,lease_term,townhouse_apt,state_id,property_type,latitude,longitude, {$haversine} AS distance")
                ->whereRaw("{$haversine} < ?", [$request->radius]);
        } elseif ($request->county && ! $request->radius) {
            $search->where('county_id', $request->county);
        } elseif ($request->county && $request->radius) {
            if ($rent) {
                return view('frontend.property.rent_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
            }

            return view('frontend.property.sale_search_view', ['search' => [], 'states' => $states, 'data' => $data]);
        }

        if ($request->street_address) {
            $search->where('street_address', 'LIKE', '%'.$request->street_address.'%');
        }
        if ($request->pets) {
            $search->where('pets', 'LIKE', '%'.config('constant.inverse_pets_welcome'.$request->pets).'%');
        }
        if ($request->lease) {

            $search->where('lease_term', 'LIKE', '%'.$request->lease.'%');

        }
        if ($request->beds && ($request->beds != '11')) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('beds', 'LIKE', '%'.$request->beds.'%');
            });
        } elseif ($request->beds == '11') {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('beds', '>=', $request->beds);
            });
        }
        if ($request->baths && ($request->baths != '8')) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('baths', 'LIKE', '%'.$request->baths.'%');
            });
        } elseif ($request->baths == '8') {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('baths', '>=', $request->baths);
            });
        }

        if ($request->acreagefrom && ! $request->acreageto) {
            //	die('1');
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('plot_size', '>=', $request->acreagefrom);

            });
        }
        if ($request->acreageto && ! $request->acreagefrom) {

            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('plot_size', '<=', $request->acreageto);
            });
        }
        if ($request->acreagefrom && $request->acreageto) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->whereBetween('plot_size', [$request->acreagefrom, $request->acreageto]);
                // 		 echo $q->toSql();die;
            });

        }
        if ($request->proptype) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('home_type', $request->proptype);
            });
        }
        if ($request->pricefrom && ($request->priceto != '90000')) {
            $search->where('price', '>=', $request->pricefrom);
        }

        if ($request->priceto && ($request->priceto != '90000')) {
            $search->where('price', '<=', $request->priceto);
        }
        if ($request->pricefrom && $request->priceto && $request->priceto == '90000') {
            $search->where('price', '>=', $request->priceto);
        }
        if ($request->pricefrom && $request->priceto && ($request->priceto != '90000')) {
            $search->whereBetween('price', [$request->pricefrom, $request->priceto]);
        }
        if ($request->home_size) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('home_size', $request->home_size);
            });
        }
        if ($request->builtmax && $request->builtYear) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->whereBetween('year_built', [$request->builtYear, $request->builtmax]);
            });
        }
        if ($request->builtYear && ! $request->builtmax) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('year_built', '>=', $request->builtYear);
            });
        }
        if ($request->builtmax && ! $request->builtYear) {
            $search->whereHas('architechture', function ($q) use ($request) {
                $q->where('year_built', '<=', $request->builtmax);
            });
        }

        //echo $search->toSql();die;
        if ($request->limit) {
            $searchResult = $search->whereHas('architechture')->with('architechture', 'images')->latest()->paginate($request->limit);
        } else {

            $searchResult = $search->whereHas('architechture')->with('architechture', 'images')->latest()->paginate(config('constant.common_pagination'));
        }
        if ($rent) {
            return view('frontend.property.rent_search_view', compact('states', 'data', 'latitude', 'longitude'))->with(['search' => $searchResult]);
        }

        return view('frontend.property.sale_search_view', compact('states', 'data', 'latitude', 'longitude'))->with(['search' => $searchResult]);
    }

    public function vacationSearch(): View
    {
        $regions = Region::get();
        $subRegions = SubRegion::get();

        return view('frontend.property.vacation_search', compact('regions', 'subRegions'));
    }

    public function vacationSearching(Request $request): View
    {
        //        dd( $request->all());
        $regions = Region::get();
        $subRegions = SubRegion::get();
        $search = null;
        if ($request->category) {
            if ($request->category == 'Timeshare') {
                $search = VacationProperty::where('property_type', config('constant.inverse_vacation_property_type.Timeshare'));
            } elseif ($request->category == 'Owner Property') {
                $search = VacationProperty::where('property_type', config('constant.inverse_vacation_property_type.Owner Property'));
            } else {
                $search = VacationProperty::where(function ($query) {
                    $query->orWhere('property_type', config('constant.inverse_vacation_property_type.Timeshare'))
                        ->orWhere('property_type', config('constant.inverse_vacation_property_type.Owner Property'));
                });
            }
        } else {
            return view('frontend.property.vacation_search', compact('regions', 'subRegions', 'request'))->with(['search' => []]);
        }
        if ($request->region) {
            $search->where('region_id', $request->region);
        }
        if ($request->subregion) {
            $search->where('subregion_id', $request->subregion);
        }
        if ($request->country) {
            $search->where('country_id', $request->country);
        }
        if ($request->state && ! $request->city) {
            $search->where('state_id', $request->state);
        }
        if ($request->city) {
            if ($request->state) {
                $search->where('state_id', $request->state)->where('city', $request->city);
            } else {
                $search->where('city', $request->city);
            }
        }

        if ($request->baths) {
            $search->where('bathrooms', $request->baths);
        }

        if ($request->beds && ($request->beds != '11')) {
            $search->where('bedrooms', 'LIKE', '%'.$request->beds.'%');
        } elseif ($request->beds == '11') {
            $search->where('bedrooms', '>=', $request->beds);
        }

        if ($request->baths && ($request->baths != '8')) {
            $search->where('bathrooms', 'LIKE', '%'.$request->baths.'%');
        } elseif ($request->baths == '8') {
            $search->where('bathrooms', '>=', $request->baths);
        }

        if ($request->pricefrom && $request->priceto) {
            $search->whereBetween('price', [$request->pricefrom, $request->priceto]);
        } elseif ($request->pricefrom) {
            $search->where('price', '>=', $request->pricefrom);
        } elseif ($request->priceto) {
            $search->where('price', '<=', $request->priceto);
        }
        if ($request->book) {
            $search->whereHas('availabilities', function ($query) use ($request) {
                $query->where('start_date', $request->book);
            });
        }
        if ($request->locks != null) {
            $search->where('lock_out_unit', $request->locks);
        }

        $search = $search->with('images', 'availableWeeks')->latest()->paginate($request->limit);

        return view('frontend.property.vacation_search', compact('search', 'regions', 'subRegions', 'request'));
    }

    public function districtAdvanceSearch(Request $request)
    {
        $schoolDistricts = SchoolDistrict::where('district', 'LIKE', '%'.$request->term.'%')->select('id', 'district')->get();
        $schoolDistricts->transform(function ($item, $key) {
            return ['id' => $item->id, 'text' => $item->district];
        });

        return response(['results' => $schoolDistricts]);
    }

    public function propertyDetails($id, $type = '')
    {

        $property = Property::where('id', $id)
            ->whereHas('user')
            ->with(['user', 'saleOffer', 'rentOffer', 'favorites', 'architechture',
                'images',
                'availability' => function ($q) {
                    $q->where('user_id', null);
                },
                'additional_information' => function ($q) {
                    $q->select('additional_information.*', 'a_i_2.name as parent_name')->join('additional_information as a_i_2', 'a_i_2.id', '=', 'additional_information.parent_id');
                },
            ])->first();

        if (! empty($property)) {
            //	    if ($property->user_id == Auth::id() && $property->status == config('constant.inverse_property_status.Unavailable')) {
            //		return redirect()->back()->withFlashDanger('Preview Listing is not available as the property is currently Inactive. Please Activate Listing to view.');
            //	    } else
            if ($property->user_id != Auth::id() && $property->status == config('constant.inverse_property_status.Unavailable')) {
                return redirect()->back()->withFlashDanger('Preview Listing is not available as the property owner have either deactivated or deleted the property.Please contact property owner.');
            }

            $state = State::where('id', $property->state_id)->first();
            $county = County::where('id', $property->county_id)->first();
            $city = City::where('id', $property->city_id)->first();
            $zipCode = ZipCode::where('id', $property->zip_code_id)->first();
            $schools = School::whereIn('id', explode(',', $property->architechture->school_id ?? 0))->get();
            $schoolDistrict = SchoolDistrict::where('id', $property->architechture->school_district_id ?? 0)->first();
            $additional_information = $property->additional_information->groupBy('parent_name');

            return view('frontend.property.details', ['property' => $property, 'schools' => $schools, 'state' => $state, 'schoolDistrict' => $schoolDistrict,
                'county' => $county, 'city' => $city, 'zipCode' => $zipCode, 'additional_information' => $additional_information]);
        } else {
            return redirect()->back()->withFlashDanger('Property not found.');
        }
    }

    public function vacationDetails($id)
    {
        if (VacationProperty::find($id)) {
            $vacation = VacationProperty::where('id', $id)->with(['images', 'availableWeeks'])->first();
            $state = State::where('id', $vacation->state_id)->first();
            $region = Region::where('id', $vacation->region_id)->first();
            $subRegion = SubRegion::where('id', $vacation->subregion_id)->first();
            $country = Country::where('id', $vacation->country_id)->first();

            return view('frontend.property.vacation-details', ['vacation' => $vacation, 'region' => $region, 'state' => $state,
                'subRegion' => $subRegion, 'country' => $country]);
        } else {
            return redirect()->back()->withFlashDanger('Property not found.');
        }
    }

    public function propertyDelete($id = null): RedirectResponse
    {
        if ($id) {
            $property = Property::where('id', $id)->where('user_id', Auth::id())->first();
            if ($property) {
                Property::where('id', $id)->delete();
                if ($property->property_type == config('constant.inverse_property_type.Sale')) {
                    return redirect()->route('frontend.property.salesList')->withFlashDanger('Sale property deleted successfully.');
                }
                if ($property->property_type == config('constant.inverse_property_type.Rent')) {
                    return redirect()->route('frontend.property.rentsList')->withFlashDanger('Rent property deleted successfully.');
                }
            }
        } else {
            return redirect()->back()->withFlashDanger('Property not found.');
        }
    }

    public function vacationPropertyDelete($id = null): RedirectResponse
    {
        if ($id) {
            if (VacationProperty::where('id', $id)->where('user_id', Auth::id())->exists()) {
                VacationProperty::where('id', $id)->delete();

                return redirect()->route('frontend.property.vacationsList')->withFlashDanger('Vacation property deleted successfully.');
            }
        } else {
            return redirect()->back()->withFlashDanger('Property not found.');
        }
    }

    public function manageAvailabilty(Request $request, $id)
    {
        $property = $this->searchAvailability($id);
        if (! $property) {
            return redirect()->back()->withFlashDanger('Property not found');
        }

        return view('frontend.property.availability')->with('property', $property);
    }

    public function addAvailability(Request $request): RedirectResponse
    {
        $data = $request->all();
        $property = Property::where(['id' => $data['property_id'], 'user_id' => Auth::id()])->get()->first();
        if (! $property) {
            return redirect()->back()->withFlashDanger('Property not found');
        } else {
            $availability = new PropertyAvailability;
            $availability->date = $data['date'] ? date('Y-m-d', strtotime($data['date'])) : date('Y-m-d');
            $startTime = new \DateTime($data['start_time']);
            $endTime = new \DateTime($data['end_time']);
            $availability->start_time = $startTime->format('H:i:s');
            $availability->end_time = $endTime->format('H:i:s');
            $property->availability()->save($availability);

            return redirect()->back()->withFlashSuccess('Availability Added');
        }
    }

    public function searchAvailability($id, $search = [])
    {
        $property = Property::where(['id' => $id, 'user_id' => Auth::id()])
            ->with(['availability' => function ($query) use ($search) {
                $query->whereYear('date', $search['selectedYear'] ?? date('Y'))
                    ->whereMonth('date', $search['selectedMonth'] ?? date('m'));
            }]);

        return $property->get()->first();
    }

    public function getAvailability(Request $request)
    {
        return $this->searchAvailability($request->get('id'), $request->get('search'));
    }

    public function destroyAvailability($id): RedirectResponse
    {
        $property = PropertyAvailability::find($id);
        if (! $property) {
            return redirect()->back()->withFlashDanger('Availability not found');
        } else {
            $property->delete();

            return redirect()->back()->withFlashSuccess('Availability Deleted');
        }
    }

    public function manageVacationAvailabilty(Request $request, $id)
    {
        $property = VacationProperty::where(['id' => $id, 'user_id' => Auth::id()])->get()->first();
        if (! $property) {
            return redirect()->back()->withFlashDanger('Property not found');
        }

        return view('frontend.property.vacation_availability')->with('property', $property);
    }

    public function getVacationAvailability(Request $request, $id)
    {
        $property = VacationProperty::where(['id' => $id, 'user_id' => Auth::id()])->get()->first();

        return $property->availabilities->pluck('start_date');
    }

    public function updateVacationDates(Request $request, $id): Response
    {
        $month = date('m', strtotime($request->date));
        $year = date('Y', strtotime($request->date));
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $list = [];
        for ($days = 1; $days <= 31; $days++) {
            $time = mktime(12, 0, 0, $month, $days, $year);
            if (date('m', $time) == $month) {
                $temp['start_date'] = date('Y-m-d', $time);
            }
            array_push($list, $temp);
        }

        $property = VacationProperty::where(['id' => $id, 'user_id' => Auth::id()])->get()->first();
        if ($property) {
            $data = ['start_date' => $request->get('date')];
            if ($request->get('type') == 'select') {
                foreach ($list as $index => $date) {
                    $property->availabilities()->create($date);
                }
            } elseif ($request->get('type') == 'add') {
                $property->availabilities()->create($data);
            } elseif ($request->get('type') == 'unselect') {
                foreach ($list as $index => $date) {
                    $property->availabilities()->where($date)->delete();
                }
            } else {
                $property->availabilities()->where($data)->delete();
            }

            return response(['status' => true]);
        }
    }

    public function confirmAvailability(Request $reqeust, $id): RedirectResponse
    {
        $event = PropertyAvailability::find($id);
        if ($event) {
            $event->user_id = Auth::id();
            $event->save();
            Mail::to($event->property->user)->send(new AvailabilityConfirmation($event, Auth::User()));

            return redirect()->back()->withFlashSuccess('Thank you for Scheduling the date and time to view the property. We have informed to the property owner via email. The property owner will get back to you as soon as possible.');
        } else {
            return redirect()->back()->withFlashDanger('Availability not found for this property');
        }
    }

    public function propertyImageDelete($id): JsonResponse
    {
        if (PropertyImage::find($id)) {
            if (PropertyImage::where('id', $id)->delete()) {

                return response()->json(['success' => true], 200);
            }

            return response()->json(['success' => false, 'message' => 'Property Image not deleted.'], 500);
        }

        return response()->json(['success' => false, 'message' => 'Please enter a valid image.'], 500);
    }

    public function contactMessage(Request $request): RedirectResponse
    {
        // dd($request->all());
        $userId = decrypt($request->user_id);
        $propertyId = decrypt($request->property_id);
        $property = Property::where('id', $propertyId)->where('user_id', $userId)->with(['user'])->first();
        if ($request->property_id && $request->user_id && $request->message && $property) {
            $message = new Message;
            $message->user_id = Auth::id();
            $message->to_user_id = $userId;
            $message->message = $request->get('message', '');
            if ($message->save()) {
                $to = $property->user->email;
                $emailSubject = 'Freezylist :  You have received a new message.';
                $userName = getFullName($property->user);
                $sender = getFullName(Auth::user());
                $conversationLInk = route('frontend.messages.conversation', encrypt(Auth::id()));
                $emailBody = 'Hi '.$userName.'You have received a new message from '.$sender.' '.$request->message.'For replying to this message please go to Your Frezylist Inbox or click on following link. '.$conversationLInk;
                $view = 'frontend.messages.sendMessageToSellerMail';

                Mail::send(new SendMessageToSeller($to, $userName, $sender, $emailSubject, $emailBody, $view, $conversationLInk, $request->message));

                $saveLog = new EmailLogService;
                $saveLog->saveLog($property->id, Auth::id(), $property->user_id, $emailSubject, $emailBody, config('constant.property_type.'.$property->property_type), url()->previous());

                return redirect()->back()->withFlashSuccess('Message sent to Property Owner.');
            }
        }

        return redirect()->back();
    }

    public function backToMarket($id): RedirectResponse
    {
        if (! empty($id) && Property::where('id', $id)->where('user_id', Auth::id())->exists()) {
            $property = Property::where('id', $id)->with(['saleOffer' => function ($saleQuery) {
                $saleQuery->where('status', config('constant.inverse_offer_status.accepted'))->first();
            }, 'rentOffer' => function ($rentQuery) {
                $rentQuery->where('status', config('constant.inverse_offer_status.accepted'))->first();
            }])->first();

            if (Property::where('id', $id)->update(['status' => config('constant.inverse_property_status.Available'), 'back_to_market_date' => \Carbon\Carbon::now()->format('Y-m-d')])) {
                //		foreach ($property->saleOffer as $saleOffer) {
                //		    SaleOffer::where('id', $saleOffer->id)->update(['status' => config('constant.inverse_offer_status.rejected_by_seller')]);
                //		}
                //		foreach ($property->rentOffer as $rentOffer) {
                //		    RentOffer::where('id', $rentOffer->id)->update(['status' => config('constant.inverse_rent_offer_status.rejected_by_landlord')]);
                //		}
            }

            return redirect()->back()->withFlashSuccess('Property back to market successfully.');
        }

        return redirect()->back()->withFlashSuccess('Something went wrong. Please try later.');
    }

    /*
     * Function Name:ChangePropertyStatus
     * Created By: Charu Anand 11-june-2019
     * Desc: Change the property status to available and not available
     */

    public function changePropertyStatus($id): RedirectResponse
    {
        $propertyData = Property::where('id', $id)->where('user_id', Auth::id())->first();
        if (! empty($id) && ! empty($propertyData)) {
            if (Property::where('id', $id)->update(['status' => config('constant.inverse_property_status.Unavailable')])) {
                if ($propertyData->property_type == config('constant.inverse_property_type.Rent')) {
                    return redirect()->route('frontend.property.rentsList')->with('flash_success', 'Property Deactivated successfully.');
                } else {
                    return redirect()->route('frontend.property.salesList')->with('flash_success', 'Property Deactivated successfully.');
                }
            }
        }

        return redirect()->back()->withFlashSuccess('Something went wrong. Please try later.');
    }
}
