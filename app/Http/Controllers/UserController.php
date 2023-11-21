<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use App\Http\Controllers\ImageController;
//use App\Http\Controllers\TagController;

use App\Models\User;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\UserAnswerRating;
use App\Models\UserQuestionRating;
use App\Models\UserQuestionFollow;
use App\Models\UserTagFollow;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function editUser()
    {
        $this->authorize('editUser', Auth::user());
        return view('pages.editUser', ['user' => Auth::user(),
            'old' => ['name' => Auth::user()->name,
                'username' => Auth::user()->username,
                'email' => Auth::user()->email ] ]);
    }

    public function updateUser(Request $request)
    {
        $this->authorize('editUser', Auth::user());
        $request->validate([
            'name' => 'required|string|max:250',
            'username' => 'required|string|max:250|unique:users,username,'.Auth::user()->id,
            'email' => 'required|email|max:250|unique:users,email,'.Auth::user()->id,
            'password' => 'nullable|min:8|confirmed'
        ]);
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->save();
        return redirect('/home')->withSuccess('You have successfully updated your profile!');
    }

}