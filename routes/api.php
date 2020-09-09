<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// User
Route::post('/register','UserController@register');
Route::post('/login','UserController@login');

Route::post('/product','ProductController@showProduct');
Route::post('/comment','ProductController@showComment');
Route::post('/bill','ProductController@showProduct');
Route::post('/user','ProductController@showProduct');
Route::post('/shop','ProductController@showProduct');
Route::post('/contact','ProductController@showContact');
Route::post('/order','ProductController@showOrder');
Route::post('/shipper','ProductController@showShipper');
Route::post('/wishlist','ProductController@showWishlist');

// Brand
Route::get('/brand','ProductController@showBrand');
Route::post('/add-brand', 'ProductController@addBrand');
Route::post('/update-brand', 'ProductController@updateBrand');
Route::post('/delete-brand', 'ProductController@deleteBrand');


// Category
Route::get('/cate','ProductController@showCate');
Route::post('/add-cate', 'ProductController@addCate');
Route::post('/update-cate', 'ProductController@updateCate');
Route::post('/delete-cate', 'ProductController@deleteCate');


// Banner
Route::get('/banner','AdminController@showBanner');
Route::post('/add-banner', 'AdminController@addBanner');
Route::post('/update-banner', 'AdminController@updateBanner');
Route::post('/delete-banner', 'AdminController@deleteBanner');