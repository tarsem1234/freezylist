<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreIndustryRequest;
use App\Http\Requests\Backend\UpdateIndustryRequest;
use App\Models\Industry;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $industries = Industry::latest()->get();

        return view('backend.industry.index', ['industries' => $industries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.industry.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndustryRequest $request): RedirectResponse
    {

        $checkIfIndustry = Industry::where('industry', $request->industry)->first();
        if ($checkIfIndustry != null) {
            return redirect()->route('admin.industries.create')->with('flash_warning',
                'Industry already exists.');
        }

        $industry = new Industry;
        $industry->industry = $request->industry;
        if ($industry->save()) {
            return redirect()->route('admin.industries.index')->with('flash_success',
                'Industry saved successfully.');
        }

        return redirect()->route('backend.industries.create')->with('flash_danger',
            'Industry not saved.');
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
     */
    public function edit(int $id): View
    {
        if ($id) {
            $industry = Industry::find($id);

            return view('backend.industry.create', ['industry' => $industry]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndustryRequest $request, int $id): RedirectResponse
    {
        //        dd($request->all());
        $input['industry'] = $request->industry;
        if (Industry::where('id', $id)->update($input)) {

            return redirect()->route('admin.industries.index')->with('flash_success',
                'Industry updated successfully.');
        }

        return redirect()->back()->with('flash_success',
            'Industry Updation Failed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if (Industry::where('id', $id)->delete()) {
            Service::where('industry_id', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Industry deleted successfully'],
                200);
        }

        return response()->json(['success' => true, 'message' => 'Industry Deletion Failed'],
            500);
    }
}
