<?php

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

// Cards
Route::controller(CardController::class)->group(function () {
    Route::get('/cards', 'list')->name('cards');
    Route::get('/cards/{id}', 'show');
});

//Profile
Route::controller(UserController::class)->group(function () {
    Route::get('/profile', 'profile');
    Route::get('/edit_user', 'editUser')->name('edit_user');
    Route::post('/update_user','updateUser')->name('update_user');
    Route::get('/users','list')->name('users');
    Route::post('delete_profile', 'deleteProfile')->name('delete_profile');
});

//Questions
Route::controller(QuestionController::class)->group(function () {
    Route::get('/question','list')->name('question');
    Route::get('/question/{id}','show');
    Route::get('/newquestion', 'showNewQuestionForm')->name('newquestion');
    Route::post('/newquestion', 'create')->name('createnewquestion');
    Route::post('/delete/{id}', 'delete')->name('deletequestion');
    Route::post('/edit/{id}', 'edit')->name('editingquestion');
    Route::get('/edit/{id}','showEditForm')->name('editquestion');

});

//Answers
Route::controller(AnswerController::class)->group(function () {
    Route::post('/question/{id}','create')->name('newanswer');
});

// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(QuestionController::class)->group(function () {
    Route::put('/api/question', 'create');
    Route::delete('/api/question/{question_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
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
