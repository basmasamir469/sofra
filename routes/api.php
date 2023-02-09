<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\client\AuthController;
use App\Http\Controllers\Api\client\OrderController;
use App\Http\Controllers\Api\client\ReviewController;
use App\Http\Controllers\Api\resturant\ResturantAuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/storeCity',[MainController::class,'storeCity']);
Route::get('/cities',[MainController::class,'cities']);
Route::post('/store-district',[MainController::class,'storeDistrict']);
Route::get('/districts',[MainController::class,'districts']);
Route::get('/search/resturants',[MainController::class,'searchResturants']);
Route::get('/search/resturants',[MainController::class,'searchResturants']);
Route::post('/store-category',[MainController::class,'storeCategory']);
Route::get('/categories',[MainController::class,'categories']);
Route::get('/settings',[MainController::class,'settings']);
Route::get('/resturant/{id}/info',[MainController::class,'resturant']);
Route::post('/client-register',[AuthController::class,'register']);
Route::post('/client-login',[AuthController::class,'login']);
Route::post('/client/reset-password',[AuthController::class,'resetPassword']);
Route::post('/client/new-password',[AuthController::class,'newPassword']);


Route::post('/resturant-register',[ResturantAuthController::class,'register']);
Route::post('/resturant-login',[ResturantAuthController::class,'login']);
Route::post('/resturant/reset-password',[ResturantAuthController::class,'resetPassword']);
Route::post('/resturant/new-password',[ResturantAuthController::class,'newPassword']);


Route::group(['middleware'=>'auth:api-clients'],function(){
    Route::get('/meals/{id}',[MealController::class,'meals']);
    Route::get('/meal/{id}',[MealController::class,'show']);
    Route::get('/offer/{id}',[OfferController::class,'show']);
    Route::get('/All-offers',[OfferController::class,'offers']);
    Route::post('/profile/update',[AuthController::class,'updateProfile']);
    Route::get('/profile/update',[AuthController::class,'updateProfile']);
    Route::post('/order/make',[OrderController::class,'makeOrder']);
    Route::post('/resturant/{id}/review/store',[ReviewController::class,'store']);
    Route::get('resturant/{id}/reviews',[ReviewController::class,'index']);
    Route::post('/client/logout',[AuthController::class,'logout']);
    Route::get('/client/currentorders',[OrderController::class,'CurrentOrders']);
    Route::post('/order/cancel',[OrderController::class,'CancelOrder']);
    Route::get('/client/previousorders',[OrderController::class,'PreviousOrders']);
    Route::post('/contact-us',[MainController::class,'contactus']);
    Route::get('/client/notifications',[OrderController::class,'notifications']);

});




Route::group(['middleware'=>'auth:api-resturants'],function(){

    Route::post('/meals/store',[MealController::class,'store']);
    Route::post('/meals/update/{id}',[MealController::class,'update']);
    Route::get('/meals',[MealController::class,'index']);
    Route::delete('/meals/delete/{id}',[MealController::class,'destroy']);
    Route::post('/offers/store',[OfferController::class,'store']);
    Route::post('/offers/update/{id}',[OfferController::class,'update']);
    Route::delete('/offers/delete/{id}',[OfferController::class,'destroy']);
    Route::get('/offers',[OfferController::class,'index']);
    Route::post('/resturant/update',[ResturantAuthController::class,'updateResturant']);
    Route::get('/resturant/update',[ResturantAuthController::class,'updateResturant']);
    Route::post('/resturant/logout',[ResturantAuthController::class,'logout']);
    Route::get('/neworders',[App\Http\Controllers\Api\resturant\OrderController::class,'NewOrders']);
    Route::post('/order/reject',[App\Http\Controllers\Api\resturant\OrderController::class,'rejectOrders']);
    Route::post('/order/accept',[App\Http\Controllers\Api\resturant\OrderController::class,'acceptOrders']);
    Route::get('/currentorders',[App\Http\Controllers\Api\resturant\OrderController::class,'CurrentOrders']);
    Route::post('/order/confirm',[App\Http\Controllers\Api\resturant\OrderController::class,'ConfirmOrder']);
    Route::get('/previousorders',[App\Http\Controllers\Api\resturant\OrderController::class,'PreviousOrders']);
    Route::get('/resturant/notifications',[App\Http\Controllers\Api\resturant\OrderController::class,'notifications']);

    Route::get('/comissions',[MainController::class,'resturantComissions']);




});


Route::group(['middleware' => ['auth:api-clients|api-resturants']], function () {
 Route::post('/register/token',[ResturantAuthController::class,'registerToken']);

});














