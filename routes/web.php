<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ResturantController;

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


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=>'auth'],function(){
    Route::get('/', function () {
        return view('home');
    });       
Route::resource('/cities', CityController::class);
Route::resource('/districts', DistrictController::class);
Route::resource('/categories', CategoryController::class);
Route::resource('/offers', OfferController::class);
Route::get('/search/offers', [OfferController::class,'search'])->name('offer_search');
Route::resource('/contacts', ContactController::class);
Route::resource('/payments', PaymentController::class);
Route::get('/search/payments', [PaymentController::class,'search'])->name('payment_search');
Route::get('/search/contacts', [ContactController::class,'search'])->name('contact_search');
Route::get('/settings/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('settings.edit');
Route::patch('/settings/update', [App\Http\Controllers\HomeController::class, 'update'])->name('settings.update');
Route::resource('/resturants', ResturantController::class);
Route::resource('/clients', ClientController::class);
Route::get('/search/clients', [ClientController::class,'search'])->name('client_search');
Route::get('/client/activate', [ClientController::class,'activate']);
Route::get('/search/resturants', [ResturantController::class,'search'])->name('resturant_search');
Route::get('/resturant/activate', [ResturantController::class,'activate']);
Route::resource('/orders', OrderController::class);
Route::get('/search/orders', [OrderController::class,'search'])->name('order_search');
Route::get('/orders/print/{id}', [OrderController::class,'print'])->name('orders.print');
Route::get('/passwords/change', [UserController::class,'changePassword'])->name('change_password');
Route::patch('/passwords/update', [UserController::class,'updatePassword'])->name('update_password');
Route::resource('/users', UserController::class);
Route::resource('/roles', RoleController::class);
});

