<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ESignActDisclosureController extends Controller
{
    public function index(): View
    {
        return view('frontend.e-sign_act_disclosure.index');
    }
}
