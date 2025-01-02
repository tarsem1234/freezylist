<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->whereHas('property')
            ->whereHas('property.user')
            ->with(['property' => function ($query) {
                $query->with('images', 'architechture');
            }, 'user'])
            ->paginate(config('constant.common_pagination'));

        return view('frontend.favorite.index', compact('favorites'));
    }

    public function favoriteStore($id): RedirectResponse
    {
        if ($id) {
            $favorite = new Favorite;
            $favorite->user_id = Auth::id();
            $favorite->property_id = $id;

            if ($favorite->save()) {

                return redirect()->back()->with(['flash_success' => 'Property added to favorite list.']);
            }

            return redirect()->back()->with(['flash_warning' => 'Property not added to favorite list.']);
        }

        return redirect()->back()->with(['flash_warning' => 'Something went wrong.']);
    }

    public function favoriteDelete($id): RedirectResponse
    {
        if (Favorite::where('id', $id)->delete()) {

            return redirect()->back()->with(['flash_success' => 'Property removed from favorites, Thanks']);
        }

        return redirect()->back()->with(['flash_warning' => 'Property can not remove from favorites.']);
    }
}
