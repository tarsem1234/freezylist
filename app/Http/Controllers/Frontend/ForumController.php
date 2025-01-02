<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreForumRequest;
use App\Http\Requests\Frontend\UpdateForumRequest;
use App\Models\Forum;
use App\Models\ForumView;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(): View
    {
        $forums = Forum::with(['totalViews', 'replies'])->latest()->paginate(config('constant.pagination_count'));

        return view('frontend.forum.index', compact('forums'));
    }

    public function create(): View
    {
        return view('frontend.forum.create');
    }

    public function store(StoreForumRequest $request): RedirectResponse
    {

        $input = $request->all();

        $forum = new Forum;
        $forum->user_id = Auth::id();
        $forum->topic = $input['forum_topic'];
        $forum->detail = $input['forum_detail'];
        $forum->save();

        return redirect()->route('frontend.forums.index')->with(['flash_success' => 'Forum saved successfully']);
    }

    public function show($id): View
    {
        $forum = Forum::where('id', $id)->with('replies')->first();
        dump($forum->toArray());
        ////        Forum $forum
        //        $view_id = $forum->views;
        //        $view_id++;
        //        Forum::where('id', $view_id)->update(['views' => $view_id]);
        //        $forumDetails = Forum::where('id', $view_id)->with('replies')->first();
        //
        //        dump($forumDetails);

        return view('frontend.forum.show', compact('forumDetails'));
    }

    public function edit(Forum $forum): View
    {
        $forumDetails = Forum::where('id', $forum->id)->first();
        dump($forumDetails->toArray());

        return view('frontend.forum.create', compact('forumDetails'));
    }

    public function update(UpdateForumRequest $request, Forum $forum): RedirectResponse
    {
        $input = $request->all();
        Forum::where('id', $forum->id)->update(['topic' => $input['forum_topic'],
            'detail' => $input['forum_detail']]);

        return redirect()->route('forntend.user.forums.index');
    }

    public function destroy(Forum $forum): RedirectResponse
    {
        Forum::where('id', $forum->id)->delete();

        return redirect()->route('forntend.user.forums.index');
    }

    public function loadMoreForums($count): JsonResponse
    {

        $count = $count + 10;
        $forums = Forum::all()->take($count);
        dd($forums);

        return response()->json($forums, $count);
    }

    public function forumRepliesShow($id)
    {
        if ($id) {
            $ip = \Request::ip();
            $forum = Forum::where('id', $id)->with(['forumViews' => function ($query) use ($ip) {
                $query->where('ip', $ip);
            }, 'replies' => function ($query1) {
                $query1->latest()->with(['user' => function ($que) {
                    $que->with('user_profile', 'business_profile');
                }]);
            }, 'user' => function ($query2) {
                $query2->with('user_profile', 'business_profile');
            }])->first();
            if ($forum && count($forum->forumViews) > 0) {

                $diff = date_diff(date_create($forum->forumViews[0]->updated_at),
                    Carbon::now());

                if ($diff->days > 0) {
                    DB::table('forum_views')->where('id',
                        $forum->forumViews[0]->id)->increment('views');
                } else {
                    $forumData = new ForumView;
                    $forumData->forum_id = $forum->id;
                    $forumData->views = 1;
                    $forumData->ip = $ip;
                    $forumData->save();
                }
            } elseif ($forum && count($forum->forumViews) <= 0) {
                $forumData = new ForumView;
                $forumData->forum_id = $forum->id;
                $forumData->views = 1;
                $forumData->ip = $ip;
                $forumData->save();
            }

            return view('frontend.forum.forum_replies', ['forum' => $forum]);
        }

        return redirect()->back();
    }
}
