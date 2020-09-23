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

// Login & register
Route::post('/register','UserController@register');
Route::post('/login','UserController@login');


// User
Route::get('/user','UserController@showUser');
Route::post('/add-user','UserController@addUser');
Route::post('/update-user','UserController@updateUser');
Route::post('/delete-user','UserController@deleteUser');

//Test
// Route::get('/test','ProductController@test');
Route::post('/post','ProductController@test');



// Product

Route::get('/product','ProductController@showProduct');
Route::post('/product-type','ProductController@productType');
Route::post('/product-shop','ProductController@productShop');
Route::post('/show-product-shop','ProductController@showProductShop');


Route::post('/add-product', 'ProductController@addProductDetail');
Route::post('/add-image', 'ProductController@uploadProductImage');
Route::post('/add-detail', 'ProductController@addProductImage');

Route::post('/detail-info','ProductController@detailInfo');
Route::post('/detail','ProductController@showDetail');
Route::post('/detail-image','ProductController@detailImage');


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
Route::get('/comment','CommentController@showComment');
Route::post('/add-comment','CommentController@addComment');
Route::post('/update-comment','CommentController@updateComment');
Route::post('/delete-comment','CommentController@deleteComment');


// Contact
Route::get('/contact','ContactController@showContact');
Route::post('/add-contact','ContactController@addContact');
Route::post('/update-contact','ContactController@updateContact');
Route::post('/delete-contact','ContactController@deleteContact');


// Order
Route::get('/order','OrderController@showOrder');
Route::post('/add-order','OrderController@addOrder');
Route::post('/update-order','OrderController@updateOrder');
Route::post('/delete-order','OrderController@deleteOrder');


// Wishlist
Route::get('/wishlist','WishlistController@showWishlist');
Route::post('/add-wishlist','WishlistController@addWishlist');

Route::post('/delete-wishlist','WishlistController@deleteWishlist');


// Shipper->chưa làm
Route::get('/shipper','AdminController@showShipper');
Route::post('/add-shipper','AdminController@addShipper');
Route::post('/update-shipper','AdminController@updateShipper');
Route::post('/delete-shipper','AdminController@deleteShipper');


// Shop
Route::get('/shop','AdminController@showShop');
Route::post('/detail-shop','AdminController@detailShop');
Route::post('/add-shop','AdminController@addShop');
Route::post('/update-shop','AdminController@updateShop');
Route::post('/delete-shop','AdminController@deleteShop');


// Bill
Route::get('/bill','AdminController@showBill');
Route::post('/add-bill','AdminController@addBill');
