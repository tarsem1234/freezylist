<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    public function index(): View
    {
        return view('frontend.index');
    }

    public function macros(): View
    {
        return view('frontend.macros');
    }

    public function landingPage(): View
    {
        return view('frontend.landing-page.landing_home');
    }
}
