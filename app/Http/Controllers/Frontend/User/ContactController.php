<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use App\Mail\Frontend\Contact\SendContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    public function index(): View
    {
        return view('frontend.contact');
    }

    public function send(SendContactRequest $request): RedirectResponse
    {
        //        dd($request->all());
        Mail::send(new SendContact($request));

        return redirect()->back()->withFlashSuccess(trans('alerts.frontend.contact.sent'));
    }
}
