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

Route::get('/', [App\Http\Controllers\BusinessController::class, 'landing'])->name('landing');

Route::get('/foodOrder', [App\Http\Controllers\BusinessController::class, 'foodOrder'])->name('foodOrder');
Route::get('/orderNow', [App\Http\Controllers\BusinessController::class, 'orderNow'])->name('orderNow');


Route::get('/saloonBooking', [App\Http\Controllers\BusinessController::class, 'saloonBooking'])->name('saloonBooking');
Route::get('/bookNow', [App\Http\Controllers\BusinessController::class,'bookNow'])->name('bookNow');

Route::post('/webhook', [App\Http\Controllers\BusinessController::class,'handleWebhook'])->name('handleWebhook');



Route::group(['prefix' => 'admin'], function () {
  Route::get('/', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
  Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');


  Route::get('/home', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('home')->middleware(['auth:admin']);


  Route::get('/addProduct', [App\Http\Controllers\Admin\AdminController::class, 'product'])->name('product')->middleware(['auth:admin']);
  Route::get('/viewProduct/{slug}', [App\Http\Controllers\Admin\AdminController::class, 'viewProduct'])->name('viewProduct')->middleware(['auth:admin']);

  Route::post('/addProduct', [App\Http\Controllers\Admin\AdminController::class, 'addProduct'])->name('addProduct')->middleware(['auth:admin']);
  Route::post('/editProduct', [App\Http\Controllers\Admin\AdminController::class, 'editProduct'])->name('editProduct')->middleware(['auth:admin']);
  Route::post('/deleteProduct', [App\Http\Controllers\Admin\AdminController::class, 'deleteProduct'])->name('deleteProduct')->middleware(['auth:admin']);

  Route::post('/addProductFeature', [App\Http\Controllers\Admin\AdminController::class, 'addProductFeature'])->name('addProductFeature')->middleware(['auth:admin']);
  Route::post('/deleteProductFeature', [App\Http\Controllers\Admin\AdminController::class, 'deleteProductFeature'])->name('deleteProductFeature')->middleware(['auth:admin']);
  Route::post('/editProductFeature', [App\Http\Controllers\Admin\AdminController::class, 'editProductFeature'])->name('editProductFeature')->middleware(['auth:admin']);

  Route::get('/reporters', [App\Http\Controllers\Admin\AdminController::class, "getNewTransactions"])->name('getNewTransactions')->middleware(['auth:admin']);

  Route::get('/allTransactions', [App\Http\Controllers\Admin\AdminController::class, 'getAllTransactions'])->name('getAllTransactions')->middleware(['auth:admin']);

  Route::get('/foodProducts', [App\Http\Controllers\Admin\AdminController::class, 'foodProducts'])->name('foodProducts')->middleware(['auth:admin']);
  Route::get('/hairProducts', [App\Http\Controllers\Admin\AdminController::class, 'hairProducts'])->name('hairProducts')->middleware(['auth:admin']);





  // Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
  // Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register']);

  Route::post('/password/email', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm']);
});

Route::group(['prefix' => 'customer'], function () {

  Route::post('/addToCart', [App\Http\Controllers\BusinessController::class, 'addToCart'])->name('addToCart');
  Route::post('/updateQuantity', [App\Http\Controllers\BusinessController::class, 'updateQuantity'])->name('updateQuantity');
  Route::get('/getCartItems', [App\Http\Controllers\BusinessController::class, 'getCartItems'])->name('getCartItems');

  Route::get('/paymentSuccess', [App\Http\Controllers\BusinessController::class, 'paymentSuccess'])->name('paymentSuccess');

  Route::get('/paymentFailed', [App\Http\Controllers\BusinessController::class, 'paymentFailed'])->name('paymentFailed');
  Route::post('/placeOrder', [App\Http\Controllers\BusinessController::class,'placeOrder'])->name('placeOrder')->middleware(['auth:customer']);

  Route::post('/checkout', [App\Http\Controllers\BusinessController::class,'checkout'])->name('checkout')->middleware(['auth:customer']);

  Route::get('/', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showLoginForm'])->name('customer.login');
  // Route::get('/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'login']);
  Route::post('/logout', [App\Http\Controllers\Customer\Auth\LoginController::class, 'logout'])->name('logout');

  // Route::get('/register', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
  Route::post('/register', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'register']);

  Route::post('/password/email', [App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
  Route::post('/password/reset', [App\Http\Controllers\Customer\Auth\ResetPasswordController::class, 'reset'])->name('password.email');
  Route::get('/password/reset', [App\Http\Controllers\Customer\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
  Route::get('/password/reset/{token}', [App\Http\Controllers\Customer\Auth\ResetPasswordController::class, 'showResetForm']);

  Route::get('/profile', [App\Http\Controllers\Customer\CustomerController::class, 'profile'])->name('profile')->middleware(['auth:customer']);
  Route::post('/deleteAddress', [App\Http\Controllers\Customer\CustomerController::class, 'deleteAddress'])->name('deleteAddress')->middleware(['auth:customer']);

  
});

