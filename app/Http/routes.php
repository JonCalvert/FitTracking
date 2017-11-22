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

Route::get('/photos', function () {
    return view('photos');
});
/*
Route::get('/photo/removephoto/{$photoId}', function () {
    return redirect()->action('PhotoController@removephoto',$photoId);
});
*/





Route::auth();

Route::get('/home', 'HomeController@index');

Route::resource('/addnewfood', 'FoodController@addnew');
Route::resource('/addfood', 'FoodController@add');
Route::resource('/addnewworkout', 'WorkoutController@addnew');
Route::resource('/addworkout', 'WorkoutController@add');
Route::get('workouts/listworkouts/{date}', 'WorkoutController@listworkouts' );
Route::get('foods/listfoods/{date}', 'FoodController@listfoods' );

Route::get('photo/removephoto/{photoId}', ['as' => 'photo.removephoto', 'uses' => 'PhotoController@removephoto']);
Route::get('photo/setdefault/{photoId}', ['as' => 'photo.setdefault', 'uses' => 'PhotoController@setdefault']);
Route::post('photo/addphoto', ['as' => 'photo.addphoto', 'uses' => 'PhotoController@addphoto']);


//Route::resource('/photo', 'PhotoController@addphoto');