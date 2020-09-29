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
Route::post('/login-member','UserController@loginMember');


// User
Route::post('/user','UserController@showUser');
Route::post('/add-user','UserController@addUser');
Route::post('/update-user','UserController@updateUser');
Route::post('/delete-user','UserController@deleteUser');

//Test
//Route::get('/test','ProductController@test');
Route::post('/post','ProductController@test');



// Product

Route::post('/product','ProductController@showProduct');
Route::post('/product-type','ProductController@productType');

Route::post('/product-cate','ProductController@productCate');
Route::post('/product-category','ProductController@productCategory');

Route::post('/search-cate','ProductController@searchCate');
Route::post('/search-category','ProductController@searchCategory');

Route::post('/search-product','ProductController@searchProduct');

Route::post('/product-shop','ProductController@productShop');
Route::post('/show-product-shop','ProductController@showProductShop');


Route::post('/add-product', 'ProductController@addProductDetail');
Route::post('/add-image', 'ProductController@uploadProductImage');
Route::post('/add-detail', 'ProductController@addProductImage');

Route::post('/detail-info','ProductController@detailInfo');
Route::post('/detail','ProductController@showDetail');
Route::post('/detail-image','ProductController@detailImage');


// Category
Route::post('/cate','CategoryController@showCate');
Route::post('/category','CategoryController@category');
Route::post('/cate-product','CategoryController@cateProduct');
Route::post('/add-cate', 'CategoryController@addCate');
Route::post('/update-cate', 'CategoryController@updateCate');
Route::post('/delete-cate', 'CategoryController@deleteCate');


// Banner
Route::post('/banner','BannerController@showBanner');
Route::post('/add-banner', 'BannerController@addBanner');
Route::post('/update-banner', 'BannerController@updateBanner');
Route::post('/delete-banner', 'BannerController@deleteBanner');


// Comment
Route::post('/comment','CommentController@showComment');
Route::post('/add-comment','CommentController@addComment');
Route::post('/update-comment','CommentController@updateComment');
Route::post('/delete-comment','CommentController@deleteComment');


// Contact
Route::post('/contact','ContactController@showContact');
Route::post('/add-contact','ContactController@addContact');
Route::post('/update-contact','ContactController@updateContact');
Route::post('/delete-contact','ContactController@deleteContact');



//Cart
Route::post('/get-cart','CartController@getCart');
Route::post('/add-cart','CartController@addCart');



// Order
Route::post('/order','OrderController@showOrder');
Route::post('/order-detail','OrderController@orderDetail');
Route::post('/add-order','OrderController@addOrder');
Route::post('/unactive-order','OrderController@unactiveOrder');
Route::post('/active-order','OrderController@activeOrder');
Route::post('/update-order','OrderController@updateOrder');
Route::post('/confirm-order','OrderController@confirmOrder');
Route::post('/finish-order','OrderController@finishOrder');
Route::post('/accept-order','OrderController@acceptOrder');
Route::post('/delete-order','OrderController@deleteOrder');


// Wishlist
Route::post('/wishlist','WishlistController@showWishlist');
Route::post('/add-wishlist','WishlistController@addWishlist');

Route::post('/delete-wishlist','WishlistController@deleteWishlist');


// Shipper
Route::post('/shipper','ShipperController@showShipper');
Route::post('/detail-shipper','ShipperController@detailShipper');
Route::post('/update-shipper','ShipperController@updateShipper');
Route::post('/delete-shipper','ShipperController@deleteShipper');


// Shop
Route::post('/shop','ShopController@accountShop');
Route::post('/show-shop','ShopController@showShop');
Route::post('/detail-shop','ShopController@detailShop');
Route::post('/add-shop','ShopController@addShop');
Route::post('/update-shop','ShopController@updateShop');
Route::post('/delete-shop','ShopController@deleteShop');


// Bill
Route::post('/bill','AdminController@showBill');
Route::post('/add-bill','AdminController@addBill');
