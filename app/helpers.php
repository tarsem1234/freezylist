<?php

use App\Models\Message;
use App\Models\Network;
use App\Models\RentOffer;
use App\Models\SaleOffer;

/**
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {

    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('access')) {

    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('access');
    }
}
if (! function_exists('active_class')) {
    function active_class($condition)
    {
        return $condition ? 'active' : '';
    }
}
if (! function_exists('history')) {

    /**
     * Access the history facade anywhere.
     */
    function history()
    {
        return app('history');
    }
}

if (! function_exists('gravatar')) {

    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (! function_exists('includeRouteFiles')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     */
    function includeRouteFiles($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (! function_exists('getRtlCss')) {

    /**
     * The path being passed is generated by Laravel Mix manifest file
     * The webpack plugin takes the css filenames and appends rtl before the .css extension
     * So we take the original and place that in and send back the path.
     *
     *
     * @return string
     */
    function getRtlCss($path)
    {
        $path = explode('/', $path);
        $filename = end($path);
        array_pop($path);
        $filename = rtrim($filename, '.css');

        return implode('/', $path).'/'.$filename.'.rtl.css';
    }
}

if (! function_exists('homeRoute')) {

    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (access()->allow('view-backend')) {
            return 'admin.dashboard';
        } elseif (auth()->check()) {
            return 'frontend.user.dashboard';
        }

        return 'frontend.index';
    }

    function fixImageRatio($image)
    {
        [$width, $height] = getimagesize($image);

        $extension = $image->getClientOriginalExtension();
        $config_image = [
            'source_image' => $image,
            'new_image' => 'target_path',
            'maintain_ratio' => false,
            'height' => $height,
            'width' => $width,
        ];

        $ratio_4by3 = 4 / 3; //a float with a value of ~1.33333333
        $ratio_source = $width / $height;
        $is_4x3 = round($ratio_source, 2) == round($ratio_4by3, 2);

        if (! $is_4x3) {
            if ($ratio_source < $ratio_4by3) {
                $config_image['height'] = (int) round($width / $ratio_4by3);
            } else {
                $config_image['width'] = (int) round($height * $ratio_4by3);
            }
        }
        //        $src = imagecreatefromjpeg($image);

        if ($extension == 'png') {
            $src = imagecreatefrompng($image);
        } elseif ($extension == 'PNG') {
            $src = imagecreatefrompng($image);
        } elseif ($extension == 'jpg') {
            $src = imagecreatefromjpeg($image);
        } elseif ($extension == 'JPG') {
            $src = imagecreatefromjpeg($image);
        } elseif ($extension == 'jpeg') {
            $src = imagecreatefromjpeg($image);
        } elseif ($extension == 'JPEG') {
            $src = imagecreatefromjpeg($image);
        } elseif ($extension == 'pjpeg') {
            $src = imagecreatefrompjpeg($image);
        } elseif ($extension == 'gif') {
            $src = imagecreatefromgif($image);
        } elseif ($extension == 'GIF') {
            $src = imagecreatefromgif($image);
        } elseif ($extension == 'pdf') {
            $src = imagecreatefrompdf($image);
        } elseif ($extension == 'PDF') {
            $src = imagecreatefrompdf($image);
        } elseif ($extension == 'tif') {
            $src = imagecreatefromtif($image);
        } elseif ($extension == 'tiff') {
            $src = imagecreatefromtiff($image);
        } elseif ($extension == 'TIF') {
            $src = imagecreatefromtif($image);
        } elseif ($extension == 'TIFF') {
            $src = imagecreatefromtiff($image);
        } elseif ($extension == 'bmp') {
            $src = imagecreatefrombmp($image);
        } elseif ($extension == 'BMP') {
            $src = imagecreatefrombmp($image);
        } elseif ($extension == 'eps') {
            $src = imagecreatefromeps($image);
        } elseif ($extension == 'EPS') {
            $src = imagecreatefromeps($image);
        } elseif ($extension == 'raw') {
            $src = imagecreatefromraw($image);
        } elseif ($extension == 'cr2') {
            $src = imagecreatefromcr2($image);
        } elseif ($extension == 'nef') {
            $src = imagecreatefromnef($image);
        } elseif ($extension == 'orf') {
            $src = imagecreatefromorf($image);
        } elseif ($extension == 'sr2') {
            $src = imagecreatefromsr2($image);
        }
        //        elseif($extension=='bmp'){ $src = imagecreatefrombmp($image); }
        //        if($extension=='tif'){ $src = imagecreatefromtif($image); }
        $dst = imagecreatetruecolor($config_image['width'], $config_image['height']);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $config_image['width'], $config_image['height'], $width, $height);

        return $dst;
    }
    function image_store($image, $imageWithRatio, $proeprtyId)
    {
        $name = date('d-m-y-h-i-s-').preg_replace('/\s+/', '-',
            trim($image->getClientOriginalName()));
        $destinationPath = storage_path(config('constant.property_image_path').'/'.$proeprtyId);

        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        imagejpeg($imageWithRatio, $destinationPath.'/'.$name);

        return $name;
    }
    function store_advertise_image($image)
    {
        $timestamp = str_replace([' ', ':'], '-', \Carbon\Carbon::now()->toDateTimeString());
        $document = Storage::disk('public')->put($timestamp, $image);

        return $document;
    }
    function store_profile_image($image)
    {
        //        $document  = Storage::disk('public')->put($proeprtyId, $image);

        $picture = $image;
        $name = date('d-m-y-h-i-s-').preg_replace('/\s+/', '-',
            trim($picture->getClientOriginalName()));
        $destinationPath = storage_path(config('constant.profile_images_path').'/'.Auth::id());

        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $picture->move($destinationPath, $name);

        return $name;
    }

    function document_store($doc)
    {
        $timestamp = str_replace([' ', ':'], '-', \Carbon\Carbon::now()->toDateTimeString());
        $document = Storage::disk('public')->put($timestamp, $doc);

        //        $document        = $doc;
        //        $name            = date('d-m-y-h-i-s-').preg_replace('/\s+/', '-',
        //                trim($document->getClientOriginalName()));
        //        $destinationPath = public_path(config('constant.document_path'));
        //
        //        if (!file_exists($destinationPath)) {
        //            mkdir($destinationPath, 0777, true);
        //        }
        //        $document->move($destinationPath, $name);
        return $document;
    }

    function per_page_search_limit()
    {
        return 1;
    }

    function city($id)
    {
        $city = App\Models\City::where('id', $id)->first();

        return $city;
    }

    function getCityName($id)
    {
        $city = App\Models\City::where('id', $id)->first();

        return $city->city;
    }
    function getNonUsCity($id)
    {
        $city = App\Models\NonUsCity::where('id', $id)->first();

        return $city->city;
    }

    function findState($id)
    {
        if ($id) {
            $state = App\Models\State::where('id', $id)->first();

            return $state['state'];
        }
    }

    function findIndustryWIthServices($id)
    {
        if ($id) {
            $industry = App\Models\Industry::where('id', $id)->with('services')->first();

            return $industry;
        }
    }
    function getSubscribedServices($id)
    {
        $service = App\Models\Service::where('id', $id)->first();

        return $service->service;
    }

    function findCountry($id)
    {
        if ($id) {
            $country = App\Models\Country::where('id', $id)->first();

            return $country->country;
        }
    }

    function findCounty($id)
    {
        if ($id) {
            $county = App\Models\County::where('id', $id)->first();

            return $county->county;
        }
    }

    function findDistrictName($id)
    {
        if ($id) {
            $district = App\Models\SchoolDistrict::where('id', $id)->first();

            return $district->district;
        }
    }

    function findRegion($id)
    {
        if ($id) {
            $region = App\Models\Region::where('id', $id)->first();

            return $region->region;
        }
    }

    function findSubRegion($id)
    {
        if ($id) {
            $subRegion = App\Models\SubRegion::where('id', $id)->first();

            return $subRegion->subregion;
        }
    }

    function findZipCode($id)
    {
        if ($id) {
            $zipCode = App\Models\ZipCode::where('id', $id)->first();

            return $zipCode->zipcode;
        }
    }

    function findSigner($id)
    {
        if ($id) {
            $user = App\Models\Access\User\User::where('id', $id)->first();

            return $user->email;
        }
    }

    function getPartnersName($partners)
    {
        if ($partners) {
            $partners = explode(',', $partners);
            $allPartners = App\Models\Access\User\User::whereIn('id', $partners)->with('user_profile', 'business_profile')->withTrashed()->get();
            foreach ($allPartners as $part) {
                $partnersName[] = getFullName($part);
            }
            $names = implode(',', $partnersName);

            return $names;
        }
    }

    function getSinglePartnerName($partner = null)
    {
        $partner = App\Models\Access\User\User::where('id', $partner)->with('user_profile', 'business_profile')->withTrashed()->first();

        $partnerName = getFullName($partner);

        return $partnerName;
    }

    function getPartnerProfile($partner = null)
    {
        $partner = App\Models\Access\User\User::where('id', $partner)->with('user_profile', 'business_profile', 'signature')->withTrashed()->first();

        return $partner;
    }

    //    Used in signature common file as we have the condition that user has changed the signatures so will pass the offer id
    function getOfferPartnerProfile($partner, $offer_id, $getName = '')
    {
        $offerPartner = App\Models\Access\User\User::where('id', $partner)->withTrashed()->with(['user_profile', 'business_profile', 'rentSignature' => function ($query) use ($offer_id, $partner) {
            $query->where('offer_id', $offer_id)->where('user_id', $partner)->first();
        }, 'signature' => function ($query) use ($offer_id, $partner) {
            $query->where('offer_id', $offer_id)
                ->where('user_id', $partner)->first();
        }])->first();
        //getname is sending while getting only fullname form signature table
        if (! empty($getName) && $getName != 'rent') {
            return $offerPartner->signature->fullname;
        } else {
            return $offerPartner;
        }

    }

    function getRentPartnerProfile($partner = null)
    {
        $partner = App\Models\Access\User\User::where('id', $partner)->withTrashed()->with('user_profile', 'business_profile', 'rentSignature')->first();

        return $partner;
    }

    function getIndustryName($id)
    {
        if ($id) {
            $industry = App\Models\Industry::where('id', $id)->first();

            return $industry ? $industry->industry : 'NA';
        }
    }

    function findsigners($storedSigners)
    {
        $signers = App\Models\Access\User\User::whereIn('id', explode(',', $storedSigners))
            ->with(['user_profile', 'business_profile'])->withTrashed()->get();

        return $signers;
    }
}

function unreadMessagesCount()
{
    return Message::where('to_user_id', auth()->id())->where('status', 0)->get()->count();
}

function sentRequestCount()
{
    return Network::where('from_user_id', Auth::id())->has('request_to_user')->where('status', 0)->count();
}

function receivedRequestCount()
{
    return Network::where('to_user_id', Auth::id())->has('request_from_user')->where('status', 0)->count();
}

function totalAssociatesCount()
{
    return Network::where(function ($query) {
        $query->where(function ($subQuery) {
            $subQuery->where('from_user_id', Auth::id())
                ->whereHas('request_to_user', function ($query) {
                    $query->where('status', 1);
                });
        })->orWhere(function ($subQuery) {
            $subQuery->where('to_user_id', Auth::id())
                ->whereHas('request_from_user', function ($query) {
                    $query->where('status', 1);
                });
        });
    })
        ->where('status', config('constant.inverse_network_request.accepted'))
        ->count();
}

function offerCount()
{
    $received = SaleOffer::where('owner_id', Auth::id())->count() + RentOffer::where('owner_id', Auth::id())->count();
    $sent = SaleOffer::where('sender_id', Auth::id())->count() + RentOffer::where('buyer_id', Auth::id())->count();
    $total = $sent + $received;

    return ['sent' => $sent, 'received' => $received, 'total' => $total];
}

//function getFullName($user = null)
//{
//    $user = $user ?? Auth::User();
//    dd($user);
//    $name = $user->user_profile->full_name ?? $user->business_profile->company_name ?? $user->full_name??"NA";
//    return ucfirst($name);
//}

/*
 * Function Name: getFullName
 * Updated by:Charu Anand 13-6-2019
 * Modification:- Client required everywhere full name like firstname,middlename,lastname
 *
 */

function getFullName($user = null)
{
    $firstName = ! empty($user->user_profile->first_name) ? $user->user_profile->first_name : '';
    $middleName = ! empty($user->user_profile->middle_name) ? ' '.$user->user_profile->middle_name : '';
    $lastName = ! empty($user->user_profile->last_name) ? ' '.$user->user_profile->last_name : '';
    $fullName = $firstName.$middleName.$lastName;
    if (! empty($fullName)) {
        $name = $fullName;
    } elseif (! empty($user->user_profile)) {
        $name = $user->full_name;
    } elseif (! empty($user->business_profile)) {
        $name = $user->business_profile->company_name;
    } else {
        $name = 'NA';
    }

    return $name;
    //    return ucfirst($name);
}

function getFirstLastName($user = null)
{
    $user = ! empty($user) ? Auth::User() : '';
    if (isset($user->user_profile)) {
        $name = $user->user_profile->first_name.' '.$user->user_profile->last_name;
    } elseif ($user->business_profile) {
        $name = $user->business_profile->company_name;
    } else {
        $name = $user->full_name;
    }

    return ucfirst($name);
}
//function sendMail($request, $subject)
//{
//    $to       = $request->email;
//    Mail::send('frontend.email.signer', ['request' => $request],
//        function($mg) use($subject,$to) {
//        $mg->to($to)
//            ->subject($subject);
//    });
//}