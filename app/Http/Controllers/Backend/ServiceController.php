<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ServiceRequest;
use App\Http\Requests\Backend\UpdateServiceRequest;
use App\Models\Industry;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $services = Service::latest()->get();

        return view('backend.service.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $industries = Industry::get();

        return view('backend.service.create', ['industries' => $industries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request): RedirectResponse
    {
        $this->validate($request,
            [
                'industry' => 'required',
                'service' => 'required|max:191',
            ]);
        $checkIfService = Service::where('service', $request->service)->where('industry_id',
            $request->industry)->first();
        if ($checkIfService != null) {
            return redirect()->route('admin.services.create')->with('flash_danger',
                'Service already exists.');
        }
        $checkIfIndustry = Industry::where('id', $request->industry)->first();
        $industry = new Service;
        $industry->industry_id = $checkIfIndustry->id;
        $industry->service = $request->service;
        if ($industry->save()) {
            return redirect()->route('admin.services.index')->with('flash_success',
                'Service saved successfully.');
        }

        return redirect()->route('backend.services.create')->with('flash_danger',
            'Service not saved.');
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
            $industries = Industry::get();
            $service = Service::where('id', $id)->with('industry')->first();

            return view('backend.service.create',
                ['service' => $service, 'industries' => $industries]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, int $id): RedirectResponse
    {
        //        dd($request->all());
        if ($request->industry) {
            $input['industry_id'] = $request->industry;
        }

        $input['service'] = $request->service;
        //update fields
        if (Service::where('id', $id)->exists()) {
            Service::where('id', $id)->update($input);

            return redirect()->route('admin.services.index')->with('flash_success',
                'Service updated successfully.');
        }

        return redirect()->back()->with('flash_success',
            'Service Updation Failed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if (Service::where('id', $id)->delete()) {

            return response()->json(['success' => true, 'message' => 'Service deleted successfully'],
                200);
        }

        return response()->json(['success' => false, 'message' => 'Service Deletion Failed'],
            500);
    }
}
