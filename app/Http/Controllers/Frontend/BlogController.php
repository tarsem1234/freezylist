<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::latest()->paginate(8);

        return view('frontend.blog.index', compact('blogs'));
    }

    public function show($slug)
    {
        if ($slug) {
            $blog = Blog::where('slug', $slug)->with(['comments' => function ($query) {
                $query->
                        where('status', config('constant.blog_comment.approved'))->latest()->with(['user' => function ($subQuery) {
                            $subQuery->with('user_profile', 'business_profile');
                        }]);
            }])->first();
            if ($blog) {
                return view('frontend.blog.single', compact('blog'));
            }

            return redirect()->back()->withFlashDanger('Invalid Blog');
        }
    }
}
