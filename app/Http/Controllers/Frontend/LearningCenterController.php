<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\CategorySession;
use App\Models\Backend\UserLearningPoint;
use App\Models\UserLearningSession;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LearningCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data['categories'] = Category::where('status', 1)->latest()->get();
        $data['level'] = UserLearningSession::getUserLevel(Auth::user());
        $data['bonusSession'] = $this->getBonusSession();

        return view('frontend.learning_center.learning_center', $data);
    }

    public function learningTopic($id)
    {
        $category = Category::where(['id' => $id, 'status' => 1])->first();
        if ($category) {
            $sessions = CategorySession::where('category_id', $id)->where('status', 1)
                ->whereHas('category', function ($query) {
                    return $query->where('status', 1);
                })
                ->whereHas('questions.options')
                ->with('category')->with('questions.options')->latest()->get();
            $categories = Category::where('status', 1)->latest()->get();

            return view('frontend.learning_center.learning_topic', ['category' => $category, 'categories' => $categories, 'sessions' => $sessions]);
        }

        return redirect()->back()->with('flash_success', 'Sessions not found.');
    }

    public function learningSession(Request $request, $id)
    {
        $isBonusSession = $request->route()->getName() === 'frontend.learning.bonus_session' ? true : false;
        $session = CategorySession::find($id);
        if ($session) {
            $emptySession = ['category_session_id' => $session->id, 'user_id' => Auth::id(), 'status' => 0];
            $emptySession['type'] = $isBonusSession ? 2 : 1;
            $userSession = UserLearningSession::where($emptySession)->first();
            if (! $userSession) {
                $emptySession['current_question_id'] = 0;
                $userSession = new UserLearningSession;
                $userSession->fill($emptySession)->save();
            }
            $session = $session->where('id', $id)->with(['questions' => function ($query) use ($userSession) {
                $query->where('id', '>', $userSession->current_question_id)->with('options');
            }])->first();

            return view('frontend.learning_center.learning_session', ['session' => $session, 'isBonusSession' => $isBonusSession]);
        }

        return redirect()->back()->with('flash_success', 'Session not found.');
    }

    public function submitAnswer(Request $request): JsonResponse
    {
        $session = CategorySession::find($request->get('s_id'));
        $isBonus = $request->get('isBonus') == '1' ? true : false;
        if ($session) {
            $learningPoints = Auth::user()->lerning_points()->where('category_session_id', $session->id)->get()->count();
            $emptySession = ['category_session_id' => $session->id, 'user_id' => Auth::id(), 'status' => 0];
            $emptySession['type'] = $isBonus ? 2 : 1;
            $userSession = UserLearningSession::where($emptySession)->first();
            $userSession->current_question_id = $request->get('q_id');
            if ($request->get('save') == 'finish') {
                $points = new UserLearningPoint;
                $points->category_session_id = $session->id;
                if ($isBonus) {
                    $bonusSession = $this->getBonusSession();
                    $points->points = ! empty($bonusSession) ? ($bonusSession->status == 0 ? config('lc_config.bonus_points') : 0) : 0;
                } else {
                    $points->points = $learningPoints == 0 ? $session->points : config('lc_config.next_attempt_points');
                }
                Auth::user()->lerning_points()->save($points);
            }
            $userSession->status = $request->get('save') == 'save' ? 0 : 1;
            $userSession->save();

            return response()->json(['status' => 'success', 'message' => '']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Session not found. Please try again']);
        }
    }

    public function getBonusSession()
    {
        $startDayOfweek = Carbon::now()->startOfWeek();
        $endDayOfweek = Carbon::now()->endOfWeek();
        $emptyWhere = ['user_id' => Auth::id(), 'type' => 2];
        $sessions = UserLearningSession::where($emptyWhere)->whereBetween('created_at', [$startDayOfweek, $endDayOfweek]);
        if ($sessions->count() > 0) {
            return $sessions->first();
        }

        UserLearningSession::where($emptyWhere)->whereDate('created_at', '<', $startDayOfweek)->delete();
        $learningPoints = Auth::User()->lerning_points()->distinct()->pluck('category_session_id');
        $userSessions = Auth::User()->sessions()->distinct()->pluck('category_session_id');
        $existingSessions = $learningPoints->merge($userSessions)->unique();
        $session = CategorySession::whereIn('id', $existingSessions)->where('status', 1)->inRandomOrder()->first();
        if (! $session) {
            $session = CategorySession::where('status', 1)->inRandomOrder()->first();
        }
        if (! empty($emptyWhere) && ! empty($session)) {
            $emptyWhere['category_session_id'] = $session->id;
            $emptyWhere['id'] = $session->id;
            $newSession = new UserLearningSession($emptyWhere);
            $newSession->save();

            return $newSession;
        }

        return null;
    }
}
