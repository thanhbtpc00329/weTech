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


Route::post('/user','ProductController@showProduct');

// Route::get('/test',function()
// {
// 	return view('upload');
// });
Route::get('/test','ProductController@test');
Route::post('/post','ProductController@test');

// Product

Route::get('/product','ProductController@showProduct');
Route::post('/product-type','ProductController@productType');
Route::post('/product-shop','ProductController@productShop');


Route::post('/add-product', 'ProductController@addProductDetail');
Route::post('/add-image', 'ProductController@uploadProductImage');
Route::post('/add-detail', 'ProductController@addProductImage');

Route::post('/detail-info','ProductController@detailInfo');
Route::post('/detail','ProductController@showDetail');
Route::post('/detail-image','ProductController@detailImage');

// Brand
Route::get('/brand','BrandController@showBrand');
Route::post('/add-brand', 'BrandController@addBrand');
Route::post('/update-brand', 'BrandController@updateBrand');
Route::post('/delete-brand', 'BrandController@deleteBrand');


// Category
Route::get('/cate','CategoryController@showCate');
Route::get('/category','CategoryController@category');
Route::post('/cate-product','CategoryController@cateProduct');
Route::post('/add-cate', 'CategoryController@addCate');
Route::post('/update-cate', 'CategoryController@updateCate');
Route::post('/delete-cate', 'CategoryController@deleteCate');


// Banner
Route::get('/banner','BannerController@showBanner');
Route::post('/add-banner', 'BannerController@addBanner');
Route::post('/update-banner', 'BannerController@updateBanner');
Route::post('/delete-banner', 'BannerController@deleteBanner');


// Comment
Route::get('/comment','UserController@showComment');
Route::post('/add-comment','UserController@addComment');
Route::post('/update-comment','UserController@updateComment');
Route::post('/delete-comment','UserController@deleteComment');


// Contact
Route::get('/contact','UserController@showContact');
Route::post('/add-contact','UserController@addContact');
Route::post('/update-contact','UserController@updateContact');
Route::post('/delete-contact','UserController@deleteContact');


// Order
Route::get('/order','UserController@showOrder');
Route::post('/add-order','UserController@addOrder');
Route::post('/update-order','UserController@updateOrder');
Route::post('/delete-order','UserController@deleteOrder');


// Wishlist
Route::get('/wishlist','UserController@showWishlist');
Route::post('/add-wishlist','UserController@addWishlist');

Route::post('/delete-wishlist','UserController@deleteWishlist');


// Shipper->chưa làm
Route::get('/shipper','AdminController@showShipper');
Route::post('/add-shipper','AdminController@addShipper');
Route::post('/update-shipper','AdminController@updateShipper');
Route::post('/delete-shipper','AdminController@deleteShipper');


// Shop
Route::get('/shop','AdminController@showShop');
Route::post('/add-shop','AdminController@addShop');
Route::post('/update-shop','AdminController@updateShop');
Route::post('/delete-shop','AdminController@deleteShop');


// Bill
Route::get('/bill','AdminController@showBill');
Route::post('/add-bill','AdminController@addBill');
