<?php

namespace App\Http\Controllers\Backend\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class SearchController.
 */
class SearchController extends Controller
{
    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        if (! $request->has('q')) {
            return redirect()
                ->route('admin.dashboard')
                ->withFlashDanger(trans('strings.backend.search.empty'));
        }

        /**
         * Process Search Results Here.
         */
        $results = null;

        return view('backend.search.index')
            ->with('search_term', $request->get('q'))
            ->with('results', $results);
    }
}
