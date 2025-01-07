<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SaveSessionCategorySessionRequest;
use App\Http\Requests\Backend\StoreCategorySessionRequest;
use App\Models\Backend\Category;
use App\Models\Backend\CategorySession;
use App\Models\Backend\CategorySessionQuestion;
use App\Models\Backend\CategorySessionQuestionOption;
use App\Models\Backend\UserLearningPoint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategorySessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($categoryId = null): View
    {
        $sessions = CategorySession::whereHas('category', function ($query) {
            $query->where('status', 1)->with('category');
        });
        $category = null;
        if ($categoryId > 0) {
            $sessions->where('category_id', $categoryId);
            $category = Category::find($categoryId);
        }
        $sessions = $sessions->latest()->get();

        return view('backend.learning_center.session_list', ['sessions' => $sessions, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id): View
    {
        $category = Category::find($id);

        return view('backend.learning_center.session_create', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorySessionRequest $request): RedirectResponse
    {
        $data = $request->all();
        $catIdExist = Category::find($data['category_id']);
        if ($catIdExist) {
            $session = new CategorySession;
            $session->category_id = $data['category_id'];
            $session->name = $data['name'];
            $session->description = $data['description'];
            $session->points = $data['points'];
            if ($session->save()) {
                $sessionPoints = new UserLearningPoint;
                $sessionPoints->user_id = Auth::id();
                $sessionPoints->category_session_id = $session->id;
                $sessionPoints->points = $session->points;
                $sessionPoints->save();
                foreach ($data['questions'] as $question) {
                    $sessionQuestion = new CategorySessionQuestion;
                    $sessionQuestion->category_session_id = $session->id;
                    $sessionQuestion->question = $question['question'];
                    $sessionQuestion->type = config('constant.inverse_session_question_type.'.$question['type']);
                    if ($sessionQuestion->save()) {
                        foreach ($question['options'] as $option) {
                            $sessionQuestionOption = new CategorySessionQuestionOption;
                            $sessionQuestionOption->category_session_question_id = $sessionQuestion->id;
                            $sessionQuestionOption->title = $option['title'];
                            if (isset($option['correct_answer'])) {
                                $sessionQuestionOption->correct_answer = $option['correct_answer'];
                            }
                            $sessionQuestionOption->save();
                        }
                    }
                }

                return redirect()->route('admin.categories.index')->with('flash_success', 'Session saved successfully.');
            }
        }

        return redirect()->route('backend.categories.create')->with('flash_danger', 'Session not saved.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        if ($id) {
            $categorySession = CategorySession::where('id', $id)->with(['category', 'questions' => function ($q) {
                $q->whereHas('options')->with('options');
            }])->first();

            return view('backend.learning_center.session_create', ['categorySession' => $categorySession]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        if (CategorySession::where('id', $id)->delete()) {

            return response()->json(['success' => true, 'message' => 'Session deleted successfully'], 200);
        }

        return response()->json(['success' => true, 'message' => 'Session Deletion Failed'], 500);
    }

    public function deactivate($id): RedirectResponse
    {

        if ($id) {
            $exist = CategorySession::find($id);
            if ($exist->count() > 0) {
                if ($exist->status == 1) {
                    if (CategorySession::where('id', $id)->update(['status' => 0])) {
                        return redirect()->route('admin.sessions.index')->with('flash_success', 'Session deactivated successfully.');
                    }
                }
                if ($exist->status == 0) {
                    if (CategorySession::where('id', $id)->update(['status' => 1])) {
                        return redirect()->route('admin.sessions.index')->with('flash_success', 'Session activated successfully.');
                    }
                }
            }

            return redirect()->back()->with('flash_success', 'Session activation/deactivation Failed.');
        }
    }

    public function saveSession(SaveSessionCategorySessionRequest $request)
    {
        $data = $request->all();
        $catIdExist = Category::find($data['category_id']);
        if ($catIdExist) {
            $session = CategorySession::find($data['id'] ?? 0) ?? new CategorySession;
            $session->category_id = $data['category_id'];
            $session->name = $data['name'];
            $session->description = $data['description'];
            $session->points = $data['points'];
            if ($session->save()) {
                $session->questions()->delete();
                foreach ($data['questions'] as $question) {
                    $sessionQuestion = new CategorySessionQuestion;
                    $sessionQuestion->category_session_id = $session->id;
                    $sessionQuestion->question = $question['question'];
                    $sessionQuestion->type = $question['type'];
                    if ($sessionQuestion->save()) {
                        $sessionQuestion->options()->delete();
                        foreach ($question['options'] as $option) {
                            $sessionQuestionOption = new CategorySessionQuestionOption;
                            $sessionQuestionOption->category_session_question_id = $sessionQuestion->id;
                            $sessionQuestionOption->title = $option['title'];
                            if (isset($option['correct_answer'])) {
                                $sessionQuestionOption->correct_answer = $option['correct_answer'];
                            }
                            $sessionQuestionOption->save();
                        }
                    }
                }

                return response()->json(['status' => true, 'message' => 'Session saved successfully.']);
            }
        }

        return response('Fail', 500)->json(['status' => false, 'message' => 'Something went wrong. Please try again']);
    }
}
