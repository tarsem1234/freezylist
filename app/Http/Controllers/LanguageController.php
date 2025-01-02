<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

/**
 * Class LanguageController.
 */
class LanguageController extends Controller
{
    public function swap($lang): RedirectResponse
    {
        session()->put('locale', $lang);

        return redirect()->back();
    }
}
