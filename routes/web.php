<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DistrictController;

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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=>'auth'],function(){
    
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
});

