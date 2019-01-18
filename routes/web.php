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
/*Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/medirSod', function () {
    return view('dashboard');
});
Route::get('/panel', function () {
    return view('dashboard');
});
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/
Route::group(['middleware'=>['guest']],function(){
    Route::get('/','Auth\LoginController@showLoginForm')->name('loginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

//    Route::get('/', function () {
//        return view('login');
//    })->name('loginFormShow');
    Route::get('/getProfile', 'UserController@getUserAuthenticated');
});

Route::group(['middleware'=>['auth']],function(){
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/medirSod', function () {
        return view('dashboard');
    })->name('medirSod');
    Route::get('/panel', function () {
        return view('dashboard');
    })->name('panel');

});

