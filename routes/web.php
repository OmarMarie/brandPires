<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect(app()->getLocale());
});
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'], function () {

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::get('/', 'HomeController@index')->name('home');

        Route::resource('users', 'UserController');
        Route::get('usersDatable', 'UserController@usersDatable')->name('usersDatable');

        Route::resource('player', 'PlayerController');
        Route::get('playersDatable', 'PlayerController@playersDatable')->name('playersDatable');

        Route::resource('brands', 'BrandController');
        Route::get('brandsDatable', 'BrandController@brandsDatable')->name('brandsDatable');

    });


    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
});