<?php

namespace App\Http\Controllers;

use App\Models\UserQuestionFollow;
use App\Models\UserTagFollow;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $questions = Question::query()->orderBy('rating')->limit(10)->get();
        if (!Auth::check()) return view('pages/home', ['questions' => $questions]);
        else {
            $followedQuestionsID = UserQuestionFollow::where('id_user', Auth::user()->getAuthIdentifier())->pluck('id_question');

            $followedQuestions = Question::query()->whereIn('question_id', $followedQuestionsID)->orderBy('rating', 'desc')->limit(20)->get();


            $followedTagsQuestions = Question::query()->whereHas('tags', function ($query) {
                $followedTagsID = UserTagFollow::where('id_user', Auth::user()->getAuthIdentifier())->pluck('id_tag');
                $query->whereIn('name', $followedTagsID);
            })->orderBy('rating', 'desc')->limit(20)->get();

            if ($followedQuestions != null) {
                $questions = $questions->diff($followedQuestions);
            }

            if ($followedTagsQuestions != null) {
                $followedTagsQuestions = $followedTagsQuestions->diff($followedQuestions);
                $questions = $questions->diff($followedTagsQuestions);
            }

            return view('pages/home', [
                'questions' => $questions,
                'followedQuestions' => $followedQuestions,
                'followedTagsQuestions' => $followedTagsQuestions
            ]);
        }
    }

    public function mainFeatures()
    {
        return view('pages/static/mainfeatures');
    }

    public function aboutUs()
    {
        return view('pages/static/aboutus');
    }

    public function contactUs()
    {
        return view('pages/static/contactus');
    }
}