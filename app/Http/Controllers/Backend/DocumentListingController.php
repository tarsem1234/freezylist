<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreDocumentListingRequest;
use App\Models\DocumentListing;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class DocumentListingController extends Controller
{
    public function index(): View
    {
        $documents = DocumentListing::with('state')->latest()->get();

        return view('backend.document-listing.index', ['documents' => $documents]);
    }

    public function create(): View
    {
        $states = State::get();

        return view('backend.document-listing.create', ['states' => $states]);
    }

    public function store(StoreDocumentListingRequest $request): RedirectResponse
    {
        if (isset($request->timeshare_calender) && ($request->timeshare_calender == 1)
            && DocumentListing::where('state_id', config('constant.instructions'))->where('status', 1)->exists()) {
            return redirect()->back()->with('flash_danger', 'You have already uploaded timeshare document. If you want to add a new, please remove previous timeshare document first.');
        }
        $checkState = State::where('id', $request->state)->first();

        if ($checkState || config('constant.instructions')) {

            $state = new DocumentListing;
            $document = $request->document;
            $name = $document->getClientOriginalName();
            $ifExists = DocumentListing::where('state_id', $request->state)->where('document', $name)->first();
            if ($ifExists) {

                $without_extension = pathinfo($name, PATHINFO_FILENAME);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $name = $without_extension.date('-Y-m-d-h-i-s.').$ext;
            } else {
                $name = $document->getClientOriginalName();
            }
            $destinationPath = public_path('/storage/documents');
            // dd($destinationPath);
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $document->move($destinationPath, $name);

            if ($request->timeshare_calender) {
                $state->status = $request->timeshare_calender;
            }
            $state->state_id = $request->state;
            $state->document = $name;
            if ($state->save()) {
                return redirect()->route('admin.document-listing.index')->with('flash_success', 'Document saved successfully.');
            }

            return redirect()->route('backend.industries.create')->with('flash_danger', 'Document not saved.');
        }

        return redirect()->back()->with('flash_warning', 'Please enter valid state.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id): View
    {
        //        if ($id) {
        //            $states = State::get();
        //            $document = DocumentListing::where('id', $id)->with('state')->first();
        //
        //            return view('backend.document-listing.create', ['document' => $document, 'states' => $states]);
        //        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //        $this->validate($request, [
        //            'state' => 'required',
        //        ]);
        //        if ($request->document) {
        //            $this->validate($request, [
        //                'document' => 'required|mimes:pdf',
        //            ]);
        //        }
        //        $checkState = State::where('id', $request->state)->first();
        //
        //        if ($checkState) {
        //            if ($request->document) {
        //                $document = document_store($request->document);
        //                $input['document'] = $document;
        //            }
        ////        dd($request->all());
        //            $input['state_id'] = $request->state;
        //            if (DocumentListing::where('id', $id)->update($input)) {
        //
        //                return redirect()->route('admin.document-listing.index')->with('flash_success', 'Document listing updated successfully.');
        //            }
        //            return redirect()->back()->with('flash_warning', 'Document listing updation failed.');
        //        }
        //        return redirect()->back()->with('flash_warning', 'Please enter valid state.');
    }

    public function destroy($id): JsonResponse
    {
        $isDocument = DocumentListing::find($id);
        $path = storage_path(config('constant.document_path'));
        if ($isDocument) {
            DocumentListing::where('id', $id)->forceDelete();
            File::delete($path.$isDocument->document);

            return response()->json(['success' => true, 'message' => 'Document listing deleted successfully'], 200);
        }

        return response()->json(['success' => true, 'message' => 'Document listing deletion failed'], 500);
    }
}
