<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

//use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function deleteComment($id): JsonResponse
    {
        if (Comment::where('id', $id)->delete()) {
            return response()->json(['success' => true,
                'message' => 'Comment deleted successfully.',
            ], 200);
        }

        return response()->json(['success' => false], 500);
    }

    public function blogComment($id): View
    {
        if ($id) {
            $blog = Blog::where('id', $id)->with('comments')->latest()->first();
            //            dd($blogs->toArray());

            return view('backend.blog.comment', compact('blog'));
        }
    }

    public function approvalComment($id): RedirectResponse
    {

        if ($id) {
            $exist = Comment::find($id);
            if ($exist->count() > 0) {
                if ($exist->status == 1) {
                    if (Comment::where('id', $id)->update(['status' => 0])) {
                        return redirect()->back()->with('flash_success',
                            'Comment Unapproved successfully.');
                    }
                }
                if ($exist->status == 0) {
                    if (Comment::where('id', $id)->update(['status' => 1])) {
                        return redirect()->back()->with('flash_success',
                            'Comment Approved successfully.');
                    }
                }
            }

            return redirect()->back()->with('flash_success',
                'Comment approval Failed.');
        }
    }
}
