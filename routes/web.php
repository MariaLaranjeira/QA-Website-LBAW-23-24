<?php

use App\Http\Controllers\TagController;
use App\Http\Controllers\UserAnswerRatingController;
use App\Http\Controllers\UserQuestionFollowController;
use App\Http\Controllers\UserQuestionRatingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserTagFollowController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/mainfeatures', 'mainFeatures')->name('mainfeatures');
    Route::get('/aboutus', 'aboutUs')->name('aboutus');
    Route::get('/contactus', 'contactUs')->name('contactus');
});

//Profile
Route::controller(UserController::class)->group(function () {
    Route::get('/profile/{id}', 'profile')->name('profile');
    Route::get('/edit_user', 'editUser')->name('edit_user');
    Route::get('/edit_profile_picture', 'editProfilePicture')->name('edit_profile_picture');
    Route::get('/delete_picture', 'deletePic')->name('delete_picture');
    Route::post('/update_user','updateUser')->name('update_user');
    Route::get('/users','list')->name('users');
    Route::post('/delete_profile', 'deleteProfile')->name('delete_profile');
    Route::post('/upload_picture', 'uploadPicture')->name('upload_picture');
    Route::post('/delete_account', 'deleteAccount')->name('delete_account');
    Route::get('/searchUsers','search')->name('search_users');
    Route::post('/block_user/{id}', 'blockUser')->name('block_user');
});

//Questions
Route::controller(QuestionController::class)->group(function () {
    Route::get('/question/{id}','show');
    Route::get('/newquestion', 'showNewQuestionForm')->name('newquestion');
    Route::get('/edit_question_picture/{id}', 'editQuestionPicture')->name('edit_question_picture');
    Route::post('/newquestion', 'create')->name('createnewquestion');
    Route::post('/question/delete/{id}', 'delete')->name('deletequestion');
    Route::post('/question/edit/{id}', 'edit')->name('editingquestion');
    Route::post('/upload_question_picture', 'uploadQuestionPicture')->name('upload_question_picture');
    Route::get('/search','search')->name('search');
});

//Answers
Route::controller(AnswerController::class)->group(function () {
    Route::post('/question/{id}','create')->name('newanswer');
    Route::post('/answer/delete/{id}', 'delete')->name('deleteanswer');
    Route::post('/answer/edit/{id}', 'edit')->name('editinganswer');
    Route::post('/upload_answer_picture', 'uploadAnswerPicture')->name('upload_answer_picture');
});

//Comments
Route::controller(CommentController::class)->group(function () {
    Route::post('/question/{id}/comment/{type}','createComment')->name('newcomment');
    Route::post('/comment/delete/{id}', 'deleteComment')->name('deletecomment');
    Route::post('/comment/edit/{id}', 'editComment')->name('editingcomment');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// Registration
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Question Votes
Route::controller(UserQuestionRatingController::class)->group(function () {
    Route::post('/question/{id}/upvote', 'upVote')->name('upvotequestion');
    Route::post('/question/{id}/downvote', 'downVote')->name('downvotequestion');
});

// AnswerVotes
Route::controller(UserAnswerRatingController::class)->group(function () {
    Route::post('/answer/{id}/upvote', 'upVote')->name('upvoteanswer');
    Route::post('/answer/{id}/downvote', 'downVote')->name('downvoteanswer');
});

// Tags
Route::controller(TagController::class)->group(function () {
    Route::get('/tags', 'list')->name('tags');
    Route::post('/tag/{name}', 'edit')->name('editTag');
    Route::get('/tag/{name}', 'show')->name('showTag');
    Route::post('/tags', 'create')->name('createTag');
    Route::post('/tag/delete/{name}', 'delete')->name('deleteTag');
});

// Question Follow
Route::controller(UserQuestionFollowController::class)->group(function () {
    Route::post('/question/{id}/follow', 'follow')->name('followquestion');
});

// Tag Follow
Route::controller(UserTagFollowController::class)->group(function () {
    Route::post('/tag/{name}/follow', 'follow')->name('followtag');
});
