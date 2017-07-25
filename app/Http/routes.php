<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/account', function () {
    return view('account');
});

Route::get('/workouts', function () {
    return view('workouts');
});

Route::get('/foods', function () {
    return view('foods');
});




Route::auth();

Route::get('/home', 'HomeController@index');

Route::resource('/addnewfood', 'FoodController@addnew');
Route::resource('/addfood', 'FoodController@add');
Route::resource('/addnewworkout', 'WorkoutController@addnew');
Route::resource('/addworkout', 'WorkoutController@add');