<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

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
        $questions = Question::query()->orderBy('rating')->limit(100)->get();
        return view('pages/home', [
            'questions' => $questions
        ]);
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