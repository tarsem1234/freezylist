<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CorporateController extends Controller
{
    public function index(): View
    {
        return view('frontend.corporate.index');
    }
}
