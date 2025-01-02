<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $pages = Page::where('slug', '!=', 'advertise')->where('slug', '!=', 'about-us')->latest()->get();

        return view('backend.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(int $id)
    {
        if ($id) {
            $page = Page::find($id);

            return view('backend.pages.create', ['page' => $page]);
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, int $id): RedirectResponse
    {
        //        dd($request->all());
        $input['title'] = $request->title;
        $input['content'] = $request->content;
        if (Page::where('id', $id)->update($input)) {

            return redirect()->route('admin.pages.index')->with('flash_success',
                'Page updated successfully.');
        }

        return redirect()->back()->with('flash_success', 'Page Updation Failed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
    }
}
