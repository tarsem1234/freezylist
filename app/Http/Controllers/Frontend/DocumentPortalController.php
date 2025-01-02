<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DocumentPortalController extends Controller
{
    public function index(): View
    {
        return view('frontend.document_portal.index');
    }
}
