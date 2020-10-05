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
Route::post('/register','UserController@register');// Register user
Route::post('/login','UserController@login');// Login user
Route::post('/login-member','UserController@loginMember'); // Login admin


// User
Route::post('/user','UserController@showUser');// Lấy tài khoản user
Route::post('/add-user','UserController@addUser');// Thêm tài khoản
Route::post('/update-user','UserController@updateUser');// Update tài khoản
Route::post('/delete-user','UserController@deleteUser');// Xóa tài khoản

//Test
//Route::get('/test','ProductController@test');
Route::post('/post','ProductController@test');



// Product

Route::post('/product','ProductController@showProduct');// Lấy sp
Route::post('/product-type','ProductController@productType');// Lấy sp theo cate_id

Route::post('/product-cate','ProductController@productCate');//Lấy sp theo danh mục con

Route::post('/product-category','ProductController@productCategory');//Lấy sp theo danh mục cha

Route::post('/search-cate','ProductController@searchCate');//Tìm kiếm sp theo danh mục con
Route::post('/search-category','ProductController@searchCategory');//Tìm kiếm sp theo danh mục cha

Route::post('/search-product','ProductController@searchProduct');// Tìm kiếm sp

Route::post('/product-shop','ProductController@productShop');// Lấy chi tiết sp theo shop
Route::post('/show-product-shop','ProductController@showProductShop');// Lấy sp theo shop

Route::post('/add-product', 'ProductController@addProduct');// Thêm sp
Route::post('/add-detail', 'ProductController@addDetail');// Thêm biến thể

Route::post('/add-image', 'ProductController@uploadProductImage');// Upload hình -> return link;

Route::post('/detail-info','ProductController@detailInfo');// Lấy thông tin chi tiết theo id sp
Route::post('/detail','ProductController@showDetail');// Lấy chi tiết sp theo id sp
Route::post('/detail-image','ProductController@detailImage');// Lấy sp theo id chi tiết sp 
Route::post('/update-product','ProductController@updateProduct');// Update sp

Route::post('/delete-product','ProductController@deleteProduct');// Xóa sp


// Category
Route::post('/cate','CategoryController@showCate');// Show all danh mục
Route::post('/category','CategoryController@category');//Lấy danh mục con
Route::post('/cate-product','CategoryController@cateProduct');//Lấy danh mục con theo cha
Route::post('/add-cate', 'CategoryController@addCate');// Thêm danh mục con
Route::post('/update-cate', 'CategoryController@updateCate');// Update cate
Route::post('/delete-cate', 'CategoryController@deleteCate');// Xóa cate


// Banner
Route::post('/banner','BannerController@showBanner');// Show all banner
Route::post('/add-banner', 'BannerController@addBanner'); // Thêm banner
Route::post('/update-banner', 'BannerController@updateBanner');//Update banner
Route::post('/delete-banner', 'BannerController@deleteBanner');// Xóa banner



//Cart
Route::post('/get-cart','CartController@getCart');
Route::post('/add-cart','CartController@addCart');



// Order
Route::post('/order','OrderController@showOrder');// Show all order
Route::post('/order-detail','OrderController@orderDetail');// Chi tiết order
Route::post('/add-order','OrderController@addOrder');// Tạo order
Route::post('/unactive-order','OrderController@unactiveOrder');// Lấy order chờ duyệt
Route::post('/active-order','OrderController@activeOrder');// Lấy order đã duyệt
Route::post('/confirm-order','OrderController@confirmOrder');// Lấy order đang giao
Route::post('/finish-order','OrderController@finishOrder');// Lấy order đã giao
Route::post('/delete-order','OrderController@deleteOrder');// Xóa order



// Shop
Route::post('/shop','ShopController@accountShop');// Lấy tài khoản shop
Route::post('/show-shop','ShopController@showShop');// Lấy all thông tin shop
Route::post('/get-shop','ShopController@getShop');// Lấy all thông tin shop đã duyệt
Route::post('/unactive-shop','ShopController@unactiveShop');// Lấy all thông tin shop chờ duyệt
Route::post('/detail-shop','ShopController@detailShop');// Chi tiết shop theo id
Route::post('/add-shop','ShopController@addShop');// Đăng ký shop

Route::post('active-shop','ShopController@activeShop');// Duyệt shop

Route::post('/update-order','ShopController@updateOrder');//Đóng gói order

Route::post('/update-shop','ShopController@updateShop');// Update shop
Route::post('/delete-shop','ShopController@deleteShop');// Xóa shop



// Comment
Route::post('/comment','CommentController@showComment');// Show all comment
Route::post('/detail-comment','CommentController@detailComment');// Lấy detail comment
Route::post('/add-comment','CommentController@addComment');// Thêm comment
Route::post('/active-comment','CommentController@activeComment');// Duyệt comment
Route::post('/delete-comment','CommentController@deleteComment');// Xóa comment


// Contact
Route::post('/contact','ContactController@showContact');// Show all contact
Route::post('/add-contact','ContactController@addContact');// Thêm contact
Route::post('/update-contact','ContactController@updateContact');// Duyệt contact
Route::post('/delete-contact','ContactController@deleteContact');// Xóa contact



// Wishlist
Route::post('/wishlist','WishlistController@showWishlist');// Show all wishlist
Route::post('/detail-wishlist','WishlistController@detailWishlist');// Chi tiết wishlist
Route::post('/add-wishlist','WishlistController@addWishlist');// Tạo wishlist
Route::post('/cart','WishlistController@cart');// Thêm vào giỏ hàng
Route::post('/delete-wishlist','WishlistController@deleteWishlist');// Xóa wishlist


// Shipper
Route::post('/shipper','ShipperController@showShipper');// Tài khoản shipper
Route::post('/detail-shipper','ShipperController@detailShipper');// Thông tin shipper
Route::post('/get-order','ShipperController@getOrder');// Đang giao order
Route::post('/accept-order','ShipperController@acceptOrder');//Đã giao order
Route::post('/update-shipper','ShipperController@updateShipper');
Route::post('/delete-shipper','ShipperController@deleteShipper');


// Admin
Route::post('admin-check','AdminController@adminCheck');

// Bill
Route::post('/bill','AdminController@showBill');
Route::post('/add-bill','AdminController@addBill');

