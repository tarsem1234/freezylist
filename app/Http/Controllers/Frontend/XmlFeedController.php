<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\XmlfeedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class XmlFeedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $password = $request->get('password', null);
            $username = $request->get('username', null);
            $existedXmlUser = XmlfeedUser::where(['username' => $username, 'status' => 1])->first();

            if (! empty($existedXmlUser) && Hash::check($password, $existedXmlUser->password)) {
                session()->put('xmlfeed_user', true);

                return redirect()->to('xmlfeed');
            } else {
                return view('frontend.xmlfeed.login')->with('error', 'Invalid credential');
            }
        }

        if (! session()->get('xmlfeed_user')) {
            return view('frontend.xmlfeed.login');
        }

        $this->xmlFeed($request);
    }

    protected function xmlFeed($request)
    {
        // Creates the Document.
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $node = $dom->createElementNS(url('/').'xml/2.2', 'xml');
        $parNode = $dom->appendChild($node);
        $dnode = $dom->createElement('Listings');
        $docNode = $parNode->appendChild($dnode);
        $properties = Property::where('status', 2)->with(['user', 'favorites', 'architechture',
            'images', 'additional_information' => function ($q) {
                $q->select('additional_information.*', 'a_i_2.name as parent_name')->join('additional_information as a_i_2', 'a_i_2.id', '=', 'additional_information.parent_id');
            }])->get();
        foreach ($properties as $property) {
            $fnode = $dom->createElement('Listing');
            $ListingNode = $dnode->appendChild($fnode);
            $additionalInformation = $property->additional_information->groupBy('parent_name');

            $Attic = $Cable_ready = $Ceilingfan = $Fireplace = $Intercom_system = $Jetted_tub = $Security_system = $Skylights = $Vaulted_ceiling = $Wet_bar = $Wired = $Double_pane_windows = $Mother_in_law_apartment = '';
            if (isset($additionalInformation['Indoor Features']) && ! $additionalInformation['Indoor Features']->isEmpty()) {
                foreach ($additionalInformation['Indoor Features']->unique('name') as $indoorFeature) {
                    if ($indoorFeature->name == 'Attic') {
                        $Attic = 'Yes';
                    } elseif ($indoorFeature->name == 'Cable ready') {
                        $Cable_ready = 'Yes';
                    } elseif ($indoorFeature->name == 'Ceiling fans') {
                        $Ceilingfan = 'Yes';
                    } elseif ($indoorFeature->name == 'Fireplace') {
                        $Fireplace = 'Yes';
                    } elseif ($indoorFeature->name == 'Intercom system') {
                        $Intercom_system = 'Yes';
                    } elseif ($indoorFeature->name == 'Jetted tub') {
                        $Jetted_tub = 'Yes';
                    } elseif ($indoorFeature->name == 'Security system') {
                        $Security_system = 'Yes';
                    } elseif ($indoorFeature->name == 'Skylights') {
                        $Skylights = 'Yes';
                    } elseif ($indoorFeature->name == 'Vaulted ceiling') {
                        $Vaulted_ceiling = 'Yes';
                    } elseif ($indoorFeature->name == 'Wet bar') {
                        $Wet_bar = 'Yes';
                    } elseif ($indoorFeature->name == 'Wired') {
                        $Wired = 'Yes';
                    } elseif ($indoorFeature->name == 'Double pane or storm windows') {
                        $Double_pane_windows = 'Yes';
                    } elseif ($indoorFeature->name == 'Mother in law apartment') {
                        $Mother_in_law_apartment = 'Yes';
                    }
                }
            }
            $patio_balcony = $Barbecue_area = $Deck = $Dock = $Fenced_yard = $Garden = $Greenhouse = $Hot_tub_spa = $Lawn = $Pond = $Pool = $Porch = $RV_parking = $Sauna = $Sprinklersystem = $Waterfront = '';
            if (isset($additionalInformation['Outdoor Amenities']) && ! $additionalInformation['Outdoor Amenities']->isEmpty()) {
                foreach ($additionalInformation['Outdoor Amenities']->unique('name') as $outdoorFeature) {
                    if ($outdoorFeature->name == 'Balcony or patio') {
                        $patio_balcony = 'Yes';
                    } elseif ($outdoorFeature->name == 'Barbecue area') {
                        $Barbecue_area = 'Yes';
                    } elseif ($outdoorFeature->name == 'Deck') {
                        $Deck = 'Yes';
                    } elseif ($outdoorFeature->name == 'Dock') {
                        $Dock = 'Yes';
                    } elseif ($outdoorFeature->name == 'Fenced yard') {
                        $Fenced_yard = 'Yes';
                    } elseif ($outdoorFeature->name == 'Garden') {
                        $Garden = 'Yes';
                    } elseif ($outdoorFeature->name == 'Greenhouse') {
                        $Greenhouse = 'Yes';
                    } elseif ($outdoorFeature->name == 'Hot tub or spa') {
                        $Hot_tub_spa = 'Yes';
                    } elseif ($outdoorFeature->name == 'Lawn') {
                        $Lawn = 'Yes';
                    } elseif ($outdoorFeature->name == 'Pond') {
                        $Pond = 'Yes';
                    } elseif ($outdoorFeature->name == 'Pool') {
                        $Pool = 'Yes';
                    } elseif ($outdoorFeature->name == 'Porch') {
                        $Porch = 'Yes';
                    } elseif ($outdoorFeature->name == 'RV parking') {
                        $RV_parking = 'Yes';
                    } elseif ($outdoorFeature->name == 'Sauna') {
                        $Sauna = 'Yes';
                    } elseif ($outdoorFeature->name == 'Sprinkler system') {
                        $Sprinklersystem = 'Yes';
                    } elseif ($outdoorFeature->name == 'Waterfront') {
                        $Waterfront = 'Yes';
                    }
                }
            }

            if ($property->property_type == 1) {
                /* Building/Development Amenities starts */
                $Basketballcourt = $Controlledaccess = $Disabledaccess = $Doorman = $Elevator = $Fitnesscenter = $Gatedentry = $Sportscourt = $Storage = $Tenniscourt = $Assisted_living_community = $Over_55_plus_active_community = $Near_transportation = '';
                if (isset($additionalInformation['Building/Development Amenities']) && ! $additionalInformation['Building/Development Amenities']->isEmpty()) {
                    foreach ($additionalInformation['Building/Development Amenities']->unique('name') as $devFeature) {
                        if ($devFeature->name == 'Basketball court') {
                            $Basketballcourt = 'Yes';
                        } elseif ($devFeature->name == 'Controlled access') {
                            $Controlledaccess = 'Yes';
                        } elseif ($devFeature->name == 'Disabled access') {
                            $Disabledaccess = 'Yes';
                        } elseif ($devFeature->name == 'Doorman') {
                            $Doorman = 'Yes';
                        } elseif ($devFeature->name == 'Elevator') {
                            $Elevator = 'Yes';
                        } elseif ($devFeature->name == 'Fitness center') {
                            $Fitnesscenter = 'Yes';
                        } elseif ($devFeature->name == 'Gated entry') {
                            $Gatedentry = 'Yes';
                        } elseif ($devFeature->name == 'Sports court') {
                            $Sportscourt = 'Yes';
                        } elseif ($devFeature->name == 'Storage') {
                            $Storage = 'Yes';
                        } elseif ($devFeature->name == 'Tennis court') {
                            $Tenniscourt = 'Yes';
                        } elseif ($devFeature->name == 'Assisted living community') {
                            $Assisted_living_community = 'Yes';
                        } elseif ($devFeature->name == 'Over 55+ active community') {
                            $Over_55_plus_active_community = 'Yes';
                        } elseif ($devFeature->name == 'Near transportation') {
                            $Near_transportation = 'Yes';
                        }
                    }
                }
            }
            /* Building/Development Amenities ends */

            /* Location node starts */
            $Location = $dom->createElement('Location');
            $LocationNode = $ListingNode->appendChild($Location);
            $StreetAddress = $dom->createElement('StreetAddress', $property->street_address);
            $LocationNode->appendChild($StreetAddress);
            $UnitNumber = $dom->createElement('UnitNumber', $property->townhouse_apt);
            $LocationNode->appendChild($UnitNumber);
            $City = $dom->createElement('City', city($property->city_id)->city);
            $LocationNode->appendChild($City);
            $State = $dom->createElement('State', findState($property->state_id));
            $LocationNode->appendChild($State);

            $Zip = $dom->createElement('Zip', findZipCode($property->zip_code_id));
            $LocationNode->appendChild($Zip);

            $decimal_limit_lat = number_format((float) $property->latitude, 6, '.', '');
            $Lat = $dom->createElement('Lat', $decimal_limit_lat);
            $LocationNode->appendChild($Lat);

            $decimal_limit_long = number_format((float) $property->longitude, 6, '.', '');
            $Long = $dom->createElement('Long', $decimal_limit_long);
            $LocationNode->appendChild($Long);

            $DisplayAddress = $dom->createElement('DisplayAddress', 'Yes');
            $LocationNode->appendChild($DisplayAddress);
            /* Location node ends */

            /* Listing Details Starts */
            $ListingDetails = $dom->createElement('ListingDetails');
            $ListingDetailsNode = $ListingNode->appendChild($ListingDetails);

            $Status = $dom->createElement('Status', 'Active');
            $StatusNode = $ListingDetailsNode->appendChild($Status);

            // Create name, and description elements and assigns them the values of the name and address columns from the results.
            $Price = $dom->createElement('Price', $property->price);
            $ListingDetailsNode->appendChild($Price);
            $ListingUrl = $dom->createElement('ListingUrl', route('frontend.propertyDetails', ['id' => $property->id]));
            $ListingDetailsNode->appendChild($ListingUrl);
            $MlsId = $dom->createElement('MlsId', $property->id);
            $ListingDetailsNode->appendChild($MlsId);
            $MlsName = $dom->createElement('MlsName', config('app.name').' Listings');
            $ListingDetailsNode->appendChild($MlsName);
            $VirtualTourUrl = $dom->createElement('VirtualTourUrl', $property->virtual_tour_url);
            $ListingDetailsNode->appendChild($VirtualTourUrl);
            $ListingEmail = $dom->createElement('ListingEmail', $property->user->email);
            $ListingDetailsNode->appendChild($ListingEmail);
            $AlwaysEmailAgent = $dom->createElement('AlwaysEmailAgent', '1');
            $ListingDetailsNode->appendChild($AlwaysEmailAgent);
            /* Listing Details Ends */
            /* Rental Deatils starts */
            if ($property->property_type == 1) {
                $RentalDetails = $dom->createElement('RentalDetails');
                $infolNode = $ListingDetailsNode->appendChild($RentalDetails);
                //setting availability to current date
                $now = new \DateTime;
                $time = $now->format('Y-m-d');

                $Availability = $dom->createElement('Availability', $time);
                $infolNode->appendChild($Availability);
                if (! empty($property['lease_term'])) {
                    $lease = explode(',', $property['lease_term']);
                    //                    if ($property['lease_term'] === config('constant.inverse_lease_terms_available.Month-To-Month')) {
                    //                        $leaseTerms = 'Monthly';
                    //                    } else if ($property['lease_term'] === config('constant.inverse_lease_terms_available.< 6 Months')) {
                    //                        $leaseTerms = 'SixMonths';
                    //                    } else if ($property['lease_term'] === config('constant.inverse_lease_terms_available.6 - 12 Months')) {
                    //                        $leaseTerms = 'OneYear';
                    //                    } else {
                    $leaseTerms = $lease[0];
                    //                    }
                } else {
                    $leaseTerms = 'ContactForDetails';
                }

                $LeaseTerm = $dom->createElement('LeaseTerm', $leaseTerms);
                $infolNode->appendChild($LeaseTerm);
                $DepositFees = $dom->createElement('DepositFees', '');
                $infolNode->appendChild($DepositFees);
                $UtilitiesIncluded = $dom->createElement('UtilitiesIncluded');
                $UtilitiesIncludedNode = $infolNode->appendChild($UtilitiesIncluded);
                $Water = $dom->createElement('Water', '');
                $UtilitiesIncludedNode->appendChild($Water);

                $PetsAllowed = $dom->createElement('PetsAllowed');
                $PetsAllowedNode = $infolNode->appendChild($PetsAllowed);
                $pets_allowed = $property->pets === config('constant.inverse_pets_welcome.Yes') ? 'Yes' : 'No';
                $Cats = $dom->createElement('Cats', $pets_allowed);
                $PetsAllowedNode->appendChild($Cats);
                $SmallDogs = $dom->createElement('SmallDogs', $pets_allowed);
                $PetsAllowedNode->appendChild($SmallDogs);
                $LargeDogs = $dom->createElement('LargeDogs', $pets_allowed);
                $PetsAllowedNode->appendChild($LargeDogs);
            }
            /* Rental Deatils ends */

            $BasicDetails = $dom->createElement('BasicDetails');
            $BasicDetailsNode = $ListingNode->appendChild($BasicDetails);

            // Create name, and description elements and assigns them the values of the name and address columns from the results.
            $PropertyType = $dom->createElement('PropertyType', config("constant.home_type_xmlfeed.$property->hometype"));
            $BasicDetailsNode->appendChild($PropertyType);

            $Title = $dom->createElement('Title', 'Property');
            $BasicDetailsNode->appendChild($Title);

            $Description = $dom->createElement('Description', $property->architechture->describe_your_home);
            $BasicDetailsNode->appendChild($Description);

            $Bedrooms = $dom->createElement('Bedrooms', $property->architechture->beds);
            $BasicDetailsNode->appendChild($Bedrooms);
            $Bathrooms = $dom->createElement('Bathrooms', $property->architechture->baths);
            $BasicDetailsNode->appendChild($Bathrooms);

            $LivingArea = $dom->createElement('LivingArea', '');
            $BasicDetailsNode->appendChild($LivingArea);
            $LotSize = $dom->createElement('LotSize', $property->architechture->plot_size);
            $BasicDetailsNode->appendChild($LotSize);
            $YearBuilt = $dom->createElement('YearBuilt', $property->architechture->year_built);
            $BasicDetailsNode->appendChild($YearBuilt);

            $Pictures = $dom->createElement('Pictures');
            $PicturesNode = $ListingNode->appendChild($Pictures);

            foreach ($property->images as $image) {
                $Picture = $dom->createElement('Picture');
                $PictureNode = $PicturesNode->appendChild($Picture);
                $PictureUrl1 = $dom->createElement('PictureUrl', htmlspecialchars(url("storage/{$image->image}")));
                $PictureNode->appendChild($PictureUrl1);
            }

            $Agent = $dom->createElement('Agent');
            $LocationNode = $ListingNode->appendChild($Agent);

            if ($property->user->hasRole('Business')) {
                $propertyUser = $property->user->business_profile;
                $FirstName = $dom->createElement('FirstName', $propertyUser->company_name ?? 'NA');
                $LocationNode->appendChild($FirstName);
                $LastName = $dom->createElement('LastName', '');
                $LocationNode->appendChild($LastName);
            } elseif ($property->user->hasRole('Business')) {
                $propertyUser = $property->user->user_profile;
                $FirstName = $dom->createElement('FirstName', $propertyUser->first_name ?? 'NA');
                $LocationNode->appendChild($FirstName);
                $LastName = $dom->createElement('LastName', $propertyUser->last_name ?? 'NA');
                $LocationNode->appendChild($LastName);
            }

            $EmailAddress = $dom->createElement('EmailAddress', $property->user->email);
            $LocationNode->appendChild($EmailAddress);
            $PictureUrl2 = $dom->createElement('PictureUrl', htmlspecialchars($property->user->picture));
            $LocationNode->appendChild($PictureUrl2);
            $OfficeLineNumber = $dom->createElement('OfficeLineNumber', $property->user->phone_no);
            $LocationNode->appendChild($OfficeLineNumber);
            $MobilePhoneLineNumber = $dom->createElement('MobilePhoneLineNumber', $property->user->phone_no);
            $LocationNode->appendChild($MobilePhoneLineNumber);

            /* Office node starts */
            $Office = $dom->createElement('Office');
            $LocationNode = $ListingNode->appendChild($Office);

            // Create name, and description elements and assigns them the values of the name and address columns from the results.
            $BrokerageName = $dom->createElement('BrokerageName', 'WWW.'.strtoupper($request->getHost()));
            $LocationNode->appendChild($BrokerageName);
            $BrokerPhone = $dom->createElement('BrokerPhone', 'NA');
            $LocationNode->appendChild($BrokerPhone);
            $StreetAddress = $dom->createElement('StreetAddress', 'ATTN: Narwhal Realty, Inc., Resident Agents, Inc., 8 The Green');
            $LocationNode->appendChild($StreetAddress);
            $UnitNumber = $dom->createElement('UnitNumber', 'STE R');
            $LocationNode->appendChild($UnitNumber);
            $City = $dom->createElement('City', 'Dover');
            $LocationNode->appendChild($City);
            $State = $dom->createElement('State', 'DE');
            $LocationNode->appendChild($State);
            $Zip = $dom->createElement('Zip', '19901');
            $LocationNode->appendChild($Zip);
            /* Office node ends */

            $OpenHouses = $dom->createElement('OpenHouses');
            $OpenHousesNode = $ListingNode->appendChild($OpenHouses);
            $PropertyName = $dom->createElement('PropertyName', $property->street_address);
            $OpenHousesNode->appendChild($PropertyName);

            /* Rich details starts */

            $RichDetails = $dom->createElement('RichDetails');
            $RichDetailsNode = $ListingNode->appendChild($RichDetails);

            // Create name, and description elements and assigns them the values of the name and address columns from the results.
            $AdditionalFeatures = $dom->createElement('AdditionalFeatures', $property->architechture->additional_features);
            $RichDetailsNode->appendChild($AdditionalFeatures);

            $Appliances = $dom->createElement('Appliances');
            $AppliancesNode = $RichDetailsNode->appendChild($Appliances);
            $this->makeNode($dom, $AppliancesNode, $additionalInformation, 'Appliances', 'Appliance');

            $arch_style = '';
            if (isset($additionalInformation['Architectural Style']) && ! $additionalInformation['Architectural Style']->isEmpty()) {
                $arch_style = $additionalInformation['Architectural Style']->unique('name')->implode('name', ', ');
            }

            $ArchitectureStyle = $dom->createElement('ArchitectureStyle', $arch_style);
            $RichDetailsNode->appendChild($ArchitectureStyle);

            $Attic = $dom->createElement('Attic', $Attic);
            $RichDetailsNode->appendChild($Attic);

            // for basement
            if (! empty($property['basement'])) {
                if ($property['basement'] == 'Finished') {
                    $basement = 'Yes';
                } elseif ($property['basement'] == 'Partially finished') {
                    $basement = 'Yes';
                } elseif ($property['basement'] == 'Unfinished') {
                    $basement = 'No';
                } else {
                    $basement = 'No';
                }
            } else {
                $basement = 'No';
            }
            // for basement

            $Basement = $dom->createElement('Basement', $basement);
            $RichDetailsNode->appendChild($Basement);
            $CableReady = $dom->createElement('CableReady', $Cable_ready);
            $RichDetailsNode->appendChild($CableReady);

            $CoolingSystems = $dom->createElement('CoolingSystems');
            $CoolingSystemsNode = $RichDetailsNode->appendChild($CoolingSystems);
            $this->makeNode($dom, $CoolingSystemsNode, $additionalInformation, 'Cooling Type', 'CoolingSystem');

            $Deck = $dom->createElement('Deck', $Deck);
            $RichDetailsNode->appendChild($Deck);
            $DoublePaneWindows = $dom->createElement('DoublePaneWindows', $Double_pane_windows);
            $RichDetailsNode->appendChild($DoublePaneWindows);

            $ExteriorTypes = $dom->createElement('ExteriorTypes');
            $ExteriorTypesNode = $RichDetailsNode->appendChild($ExteriorTypes);
            $this->makeNode($dom, $ExteriorTypesNode, $additionalInformation, 'Exterior', 'ExteriorType');

            $Fireplace = $dom->createElement('Fireplace', $Fireplace);
            $RichDetailsNode->appendChild($Fireplace);

            $FloorCoverings = $dom->createElement('FloorCoverings');
            $FloorCoveringsNode = $RichDetailsNode->appendChild($FloorCoverings);
            $this->makeNode($dom, $FloorCoveringsNode, $additionalInformation, 'Floor Covering', 'FloorCovering');

            $Garden = $dom->createElement('Garden', $Garden);
            $RichDetailsNode->appendChild($Garden);

            $HeatingFuels = $dom->createElement('HeatingFuels');
            $HeatingFuelsNode = $RichDetailsNode->appendChild($HeatingFuels);
            $this->makeNode($dom, $HeatingFuelsNode, $additionalInformation, 'Heating Fuel', 'HeatingFuel');

            $HeatingSystems = $dom->createElement('HeatingSystems');
            $HeatingSystemsNode = $RichDetailsNode->appendChild($HeatingSystems);
            $this->makeNode($dom, $HeatingSystemsNode, $additionalInformation, 'Heating Type', 'HeatingSystem');

            $JettedBathTub = $dom->createElement('JettedBathTub', $Jetted_tub);
            $RichDetailsNode->appendChild($JettedBathTub);
            $Lawn = $dom->createElement('Lawn', $Lawn);
            $RichDetailsNode->appendChild($Lawn);
            $MotherInLaw = $dom->createElement('MotherInLaw', $Mother_in_law_apartment);
            $RichDetailsNode->appendChild($MotherInLaw);

            $NumFloors = $dom->createElement('NumFloors', $property->architechture->stories);
            $RichDetailsNode->appendChild($NumFloors);
            $NumParkingSpaces = $dom->createElement('NumParkingSpaces', $property->architechture->garage_capacity);
            $RichDetailsNode->appendChild($NumParkingSpaces);

            $ParkingTypes = $dom->createElement('ParkingTypes');
            $ParkingTypesNode = $RichDetailsNode->appendChild($ParkingTypes);
            $this->makeNode($dom, $ParkingTypesNode, $additionalInformation, 'Parking', 'ParkingType');

            $Patio = $dom->createElement('Patio', $patio_balcony);
            $RichDetailsNode->appendChild($Patio);
            $Porch = $dom->createElement('Porch', $Porch);
            $RichDetailsNode->appendChild($Porch);

            $RoofTypes = $dom->createElement('RoofTypes');
            $RoofTypesNode = $RichDetailsNode->appendChild($RoofTypes);
            $this->makeNode($dom, $RoofTypesNode, $additionalInformation, 'Roof Type', 'RoofType');

            $RoomCount = $dom->createElement('RoomCount', $property->architechture->total_rooms);
            $RichDetailsNode->appendChild($RoomCount);

            $Rooms = $dom->createElement('Rooms');
            $RoomsNode = $RichDetailsNode->appendChild($Rooms);
            $this->makeNode($dom, $RoomsNode, $additionalInformation, 'Rooms', 'Room');

            $SecuritySystem = $dom->createElement('SecuritySystem', $Security_system);
            $RichDetailsNode->appendChild($SecuritySystem);
            $Skylight = $dom->createElement('Skylight', $Skylights);
            $RichDetailsNode->appendChild($Skylight);
            $SprinklerSystem = $dom->createElement('SprinklerSystem', $Sprinklersystem);
            $RichDetailsNode->appendChild($SprinklerSystem);

            $ViewTypes = $dom->createElement('ViewTypes');
            $ViewTypesNode = $RichDetailsNode->appendChild($ViewTypes);
            $this->makeNode($dom, $ViewTypesNode, $additionalInformation, 'View', 'ViewType');

            $Waterfront = $dom->createElement('Waterfront', $Waterfront);
            $RichDetailsNode->appendChild($Waterfront);

            $YearUpdated = $dom->createElement('YearUpdated', $property->architechture->year_updated);
            $RichDetailsNode->appendChild($YearUpdated);
            /* Rich details ends */

            /* Rental property extra details */
            if ($property->property_type == 1) {
                $FitnessCenter = $dom->createElement('FitnessCenter', $Fitnesscenter);
                $RichDetailsNode->appendChild($FitnessCenter);
                $BasketballCourt = $dom->createElement('BasketballCourt', $Basketballcourt);
                $RichDetailsNode->appendChild($BasketballCourt);
                $TennisCourt = $dom->createElement('TennisCourt', $Tenniscourt);
                $RichDetailsNode->appendChild($TennisCourt);

                $NearTransportation = $dom->createElement('NearTransportation', $Near_transportation);
                $RichDetailsNode->appendChild($NearTransportation);

                $ControlledAccess = $dom->createElement('ControlledAccess', $Controlledaccess);
                $RichDetailsNode->appendChild($ControlledAccess);
                $Over55ActiveCommunity = $dom->createElement('Over55ActiveCommunity', $Over_55_plus_active_community);
                $RichDetailsNode->appendChild($Over55ActiveCommunity);
                $AssistedLivingCommunity = $dom->createElement('AssistedLivingCommunity', $Assisted_living_community);
                $RichDetailsNode->appendChild($AssistedLivingCommunity);
                $Storage = $dom->createElement('Storage', $Storage);
                $RichDetailsNode->appendChild($Storage);

                $FencedYard = $dom->createElement('FencedYard', $Fenced_yard);
                $RichDetailsNode->appendChild($FencedYard);
            }

        }
        header('Content-Type: text/xml');
        exit($dom->saveXML());
    }

    public function makeNode(&$dom, &$parentNode, $collection, $key, $nodeName)
    {
        if (isset($collection[$key]) && ! $collection[$key]->isEmpty()) {
            foreach ($collection[$key]->unique('name') as $item) {
                $node = $dom->createElement($nodeName, $item->name);
                $parentNode->appendChild($node);
            }
        }
    }
}
