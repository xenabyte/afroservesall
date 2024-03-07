<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::group(['domain' => 'admin.' . env('APP_DOMAIN')], function () {
  Route::get('/login', 'Admin\Auth\LoginController@showLoginForm');
  Route::post('/login', 'Admin\Auth\LoginController@login');
  Route::post('/logout', 'Admin\Auth\LoginController@logout');

  Route::get('/register', 'Admin\Auth\RegisterController@showRegistrationForm');
  Route::post('/register', 'Admin\Auth\RegisterController@register');

  Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset');
  Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
});

Route::group(['domain' => 'customer.' . env('APP_DOMAIN')], function () {
  Route::get('/login', 'Customer\Auth\LoginController@showLoginForm');
  Route::post('/login', 'Customer\Auth\LoginController@login');
  Route::post('/logout', 'Customer\Auth\LoginController@logout');

  Route::get('/register', 'Customer\Auth\RegisterController@showRegistrationForm');
  Route::post('/register', 'Customer\Auth\RegisterController@register');

  Route::post('/password/email', 'Customer\Auth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'Customer\Auth\ResetPasswordController@reset');
  Route::get('/password/reset', 'Customer\Auth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'Customer\Auth\ResetPasswordController@showResetForm');
});
