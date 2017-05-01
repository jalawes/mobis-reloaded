<?php

/////////////////////////////////////////////////////////////////
/// 1. General Routes
/////////////////////////////////////////////////////////////////
Route::get('/', function () {
  return view('welcome');
})->name('default');
Auth::routes();
Route::get('logout', function () {
    Auth::logout();
    return view('welcome');
})->name('logout');

Route::get('home', 'HomeController@index')->name('home');
Route::get('quiz', 'QuizController@index')->name('quiz');
Route::resource('test', 'TestController');
Route::resource('users', 'UserController');

/////////////////////////////////////////////////////////////////
// 2. API Routes
/////////////////////////////////////////////////////////////////
Route::group(['prefix' => 'api'], function () {
    Route::resource('quiz', 'QuestionController');
    Route::get('test', 'TestController@getTest');
});
