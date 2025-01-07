<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DocumentListing;
use App\Models\Page;
use App\Models\State;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //    public function index()
    //    {
    //        $pages = Page::latest()->get();
    //
    //        return view('backend.pages.index', ['pages' => $pages]);
    //    }

    public function aboutUs(): View
    {
        $page = Page::where('title', 'About Us')->first();

        return view('frontend.pages.about_us', compact('page'));
    }

    public function corporate(): View
    {
        $page = Page::where('title', 'Corporate')->first();

        return view('frontend.pages.corporate', compact('page'));
    }

    public function termOfUse(): View
    {
        $page = Page::where('title', 'Term of Use & Limited Liability')->first();

        return view('frontend.pages.terms', compact('page'));
    }

    public function privacyPolicy(): View
    {
        $page = Page::where('title', 'Privacy Policy')->first();

        return view('frontend.pages.privacy_policy', compact('page'));
    }

    public function eSign(): View
    {
        $page = Page::where('title', 'E-Sign Act Disclosure')->first();

        return view('frontend.pages.e-sign_act_disclosure', compact('page'));
    }

    public function help(): View
    {
        $page = Page::where('title', 'Help')->first();

        return view('frontend.pages.help', compact('page'));
    }

    public function documentPortal(): View
    {
        $states = State::with('documents')->paginate(12);

        return view('frontend.pages.document_portal', compact('states'));
    }

    public function documentsList($stateId): View
    {
        $documents = DocumentListing::where('state_id', $stateId)->paginate(5);

        return view('frontend.pages.documents_list', compact('documents'));
    }

    public function getPage($slug = null)
    {
        if (! $slug) {
            return redirect()->back();
        }

        if ($slug == 'about-us') {
            return $this->aboutUs();
        }
        if ($slug == 'corporate') {
            return $this->corporate();
        }
        if ($slug == 'help') {
            return $this->help();
        }
        if ($slug == 'privacy-policy') {
            return $this->privacyPolicy();
        }
        if ($slug == 'term-of-use-&-limited-liability') {
            return $this->termOfUse();
        }
        if ($slug == 'e-sign-act-disclosure') {
            return $this->eSign();
        }

        return redirect()->back();
    }
}
