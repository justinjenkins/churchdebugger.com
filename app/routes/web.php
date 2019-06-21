<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::match(['get', 'post'], '/webhooks/twilio/message', 'TextsController@store');

Route::get('/{imageid}', 'ImagesController@show')->where('imageid', '^[a-zA-Z0-9]{8}$');

// return just the image.
Route::get('/images/{imageid}.jpg', 'ImagesController@download')->where('imageid', '^[a-zA-Z0-9]{8}$');
Route::get('/images/random.jpg', 'ImagesController@download');

Route::resource('images', 'ImagesController');