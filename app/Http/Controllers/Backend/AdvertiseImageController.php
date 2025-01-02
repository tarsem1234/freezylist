<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreAdvertiseImageRequest;
use App\Models\Backend\AdvertiseImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdvertiseImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $advertiseImages = AdvertiseImage::get();

        return view('backend.advertise-images.index', ['advertiseImages' => $advertiseImages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.advertise-images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertiseImageRequest $request): RedirectResponse
    {

        // Removing App name
        $reducedLink = str_replace(asset('/'), '', $request->page_link);

        $advImage = store_advertise_image($request->advertise_image);
        $advertise = new AdvertiseImage;
        $advertise->page_link = $reducedLink;
        $advertise->image = $advImage;

        if ($advertise->save()) {
            return redirect()->route('admin.advertise-images.index')->with('flash_success',
                'Advertise saved successfully.');
        }

        return redirect()->route('backend.advertise-images.create')->with('flash_danger',
            'Advertise not saved.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id) {}

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $advertiseImage = AdvertiseImage::where('id', $id)->first();
        if ($advertiseImage) {
            if (File::deleteDirectory(public_path('storage/'.strstr($advertiseImage->image, '/', true)))) {
                AdvertiseImage::where('id', $id)->forceDelete();

                return response()->json(['success' => true, 'message' => 'Advertise deleted successfully'],
                    200);
            }
        }

        return response()->json(['success' => true, 'message' => 'Advertise deletion failed'],
            500);
    }
}
