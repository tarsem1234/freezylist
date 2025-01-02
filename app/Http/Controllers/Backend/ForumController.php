<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\ForumReply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(): View
    {
        $forums = Forum::latest()->with('totalViews', 'replies', 'user')->get();

        //        dd($forums->toArray());
        return view('backend.forum.index', compact('forums'));
    }

    public function details($id) {}

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Forum $forum): View
    {
        $forumDetails = Forum::where('id', $forum->id)->with('replies', 'user')->first();

        return view('backend.forum.show', compact('forumDetails'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Forum $forum): JsonResponse
    {
        if (Forum::where('id', $forum->id)->delete()) {
            return response()->json(['success' => true, 'message' => 'Forum deleted successfully'], 200);
        }

        return response()->json(['success' => true, 'message' => 'Forum deletion failed'], 500);
    }

    public function deleteReply($id): JsonResponse
    {
        if (ForumReply::where('id', $id)->delete()) {
            return response()->json(['success' => true,
                'message' => 'Reply deleted successfully.',
            ], 200);
        }

        return response()->json(['success' => false], 500);
    }
}
