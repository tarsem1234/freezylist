<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PrivacyPolicyController extends Controller
{
    public function index(): View
    {
        return view('frontend.privacy_policy.index');
    }
}
