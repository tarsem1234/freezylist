<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Blog\StoreBlogPost;
use App\Http\Requests\Backend\UpdateBlogRequest;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::latest()->get();

        return view('backend.blog.index', compact('blogs'));
    }

    public function create(): View
    {
        return view('backend.blog.create');
    }

    public function store(StoreBlogPost $request): RedirectResponse
    {
        $input = $request->all();

        if ((strpos($input['blog_title'], '"'))) {
            return redirect()->back()->withFlashDanger(trans('alerts.blog.createFailed'));
        }

        $slug = strtolower($input['blog_title']);
        $slug = trim(str_replace(' ', '-', $slug));
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);

        if ($slug == '') {
            return redirect()->back()->withFlashDanger(trans('alerts.blog.createFailed'));
        } else {
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());

            if (Blog::where('slug', $slug)->exists()) {
                $slug = $slug.$timestamp;
            }

            $document = Storage::disk('public')->put($timestamp, $input['blog_image']);
            $blog = new Blog;
            $blog->title = $input['blog_title'];
            $blog->slug = $slug;
            $blog->description = $input['blog_description'];
            $blog->content = $input['blog_content'];
            $blog->image = $document;
            if ($blog->save()) {

                return redirect()->route('admin.blogs.index')->with('flash_success', 'Blog saved successfully.');
            }

            return redirect()->route('backend.blogs.create')->with('flash_danger', 'Blog not saved.');
        }
    }

    public function show(Blog $blog): View
    {
        return view('backend.blog.show', compact('blog'));
    }

    public function edit(Blog $blog): View
    {
        return view('backend.blog.create', compact('blog'));
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $input['title'] = $request->blog_title;
        $input['description'] = $request->blog_description;
        $input['content'] = $request->blog_content;
        if (isset($request->blog_image)) {
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $document = Storage::disk('public')->put($timestamp, $request['blog_image']);
            $input['image'] = $document;
        }
        if (Blog::where('id', $blog->id)->update($input)) {

            return redirect()->route('admin.blogs.index')->with('flash_success', 'Blog updated successfully.');
        }

        return redirect()->back()->with('flash_success', 'Blog Updation Failed.');
    }

    public function destroy($id): JsonResponse
    {
        $blog = Blog::where('id', $id)->first();
        if ($blog) {
            if (File::deleteDirectory(public_path('storage/'.strstr($blog->image, '/', true)))) {
                Blog::where('id', $id)->forceDelete();

                return response()->json(['success' => true,
                    'message' => 'Blog deleted successfully.',
                ], 200);
            }
        }

        return response()->json(['success' => false], 500);
    }

    public function blogComment($id): View
    {
        if ($id) {
            $blog = Blog::where('id', $id)->with('comments')->latest()->first();

            return view('backend.blog.comment', compact('blog'));
        }
    }
}
