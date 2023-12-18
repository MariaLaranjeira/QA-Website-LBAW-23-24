<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// routes/web.php


Route::get('/', function () {
    return redirect('/home');
});

// Home
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
});

//Profile
Route::controller(UserController::class)->group(function () {
    Route::get('/profile', 'profile');
    Route::get('/edit_user', 'editUser')->name('edit_user');
    Route::get('/edit_profile_picture', 'editProfilePicture')->name('edit_profile_picture');
    Route::get('/delete_picture', 'deletePic')->name('delete_picture');
    Route::post('/update_user','updateUser')->name('update_user');
    Route::get('/users','list')->name('users');
    Route::post('/delete_profile', 'deleteProfile')->name('delete_profile');
    Route::post('/upload_picture', 'uploadPicture')->name('upload_picture');
});

//Questions
Route::controller(QuestionController::class)->group(function () {
    Route::get('/question/{id}','show');
    Route::get('/newquestion', 'showNewQuestionForm')->name('newquestion');
    Route::post('/newquestion', 'create')->name('createnewquestion');
    Route::post('/question/delete/{id}', 'delete')->name('deletequestion');
    Route::post('/question/edit/{id}', 'edit')->name('editingquestion');
    Route::post('/search','search')->name('search');
});

//Answers
Route::controller(AnswerController::class)->group(function () {
    Route::post('/question/{id}','create')->name('newanswer');
    Route::post('/answer/delete/{id}', 'delete')->name('deleteanswer');
    Route::post('/answer/edit/{id}', 'edit')->name('editinganswer');
});

//Comments
Route::controller(CommentController::class)->group(function () {
    Route::post('/question/{id}/comment/{type}','createComment')->name('newcomment');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});
