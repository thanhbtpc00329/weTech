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
Route::post('/user-unactive','UserController@showUnactiveUser');// Lấy tài khoản user chưa duyệt
Route::post('/user-active','UserController@showActiveUser');// Lấy tài khoản user đã duyệt
Route::post('/active-account','UserController@activeAccount');// Duyệt tài khoản người dùng
Route::post('/unactive-account','UserController@unactiveAccount');// Vô hiệu hóa tài khoản người dùng
Route::post('/update-account','UserController@updateAccount');// Update tài khoản
Route::post('/upload-avatar', 'UserController@uploadAvatar');// Update avatar







// Product

Route::post('/product','ProductController@showProduct');// Lấy sp
Route::post('/product-user','ProductController@showProductUser');// Lấy sp web
Route::post('/product-type','ProductController@productType');// Lấy sp theo cate_id

Route::post('/product-cate','ProductController@productCate');//Lấy sp theo danh mục con

Route::post('/product-category','ProductController@productCategory');//Lấy sp theo danh mục cha

Route::post('/product-shop','ProductController@productShop');// Lấy chi tiết sp theo shop
Route::post('/detail-product-shop','ProductController@detailProductShop');// Lấy chi tiết sp theo shop

Route::post('/show-product-shop','ProductController@showProductShop');// Lấy sp theo shop

Route::post('/add-product', 'ProductController@addProduct');// Thêm sp
Route::post('/add-detail', 'ProductController@addDetail');// Thêm biến thể

Route::post('/add-image', 'ProductController@uploadProductImage');// Upload hình -> return link;

Route::post('/detail-info','ProductController@detailInfo');// Lấy thông tin chi tiết theo id sp
Route::post('/detail','ProductController@showDetail');// Lấy chi tiết sp theo id sp
Route::post('/detail-image','ProductController@detailImage');// Lấy sp theo id chi tiết sp 
Route::post('/update-product','ProductController@updateProduct');// Update sp

Route::post('/delete-product','ProductController@deleteProduct');// Xóa sp
Route::post('/prodetail-shop', 'ProductController@prodetailShop');// chi tiết sp
Route::post('/image-detail-shop', 'ProductController@imageDetailShop');// chi tiết hình ảnh shop
Route::post('/product-discount', 'ProductController@productDiscount');// Lấy sp khuyến mãi

Route::post('/update-product-image','ProductController@updateProductImage');// Update hình ảnh sp








// Search
Route::post('/search-cate','ProductController@searchCate');//Tìm kiếm sp theo danh mục con
Route::post('/search-category','ProductController@searchCategory');//Tìm kiếm sp theo danh mục cha

Route::post('/search-product','ProductController@searchProduct');// Tìm kiếm sp









// Category
Route::post('/cate','CategoryController@showCate');// Show all danh mục theo cha
Route::post('/cate-active-admin','CategoryController@showCateActive');// Show all danh mục active
Route::post('/cate-unactive-admin','CategoryController@showCateUnactive');// Show all danh mục unactive
Route::post('/category','CategoryController@category');//Lấy danh mục cha
Route::post('/cate-product','CategoryController@cateProduct');//Lấy danh mục con theo cha
Route::post('/add-cate', 'CategoryController@addCate');// Thêm danh mục con
Route::post('/update-cate', 'CategoryController@updateCate');// Update cate
Route::post('/delete-cate', 'CategoryController@deleteCate');// Xóa cate










// Banner
Route::post('show-banner', 'BannerController@banner');// Lấy banner lên trang chủ
Route::post('/banner','BannerController@showBanner');// Show all banner
Route::post('/add-banner', 'BannerController@addBanner'); // Thêm banner
Route::post('/active-banner', 'BannerController@activeBanner');//Active banner
Route::post('/unactive-banner', 'BannerController@unactiveBanner');//Unactive banner
Route::post('/delete-banner', 'BannerController@deleteBanner');// Xóa banner








//Cart
Route::post('/get-cart','CartController@getCart');
Route::post('/add-cart','CartController@addCart');








// Order
Route::post('/order','OrderController@showOrder');// Show all order
Route::post('/get-order-shipper','OrderController@showOrderShipper');// Lấy đơn hàng shipper
Route::post('/order-detail','OrderController@orderDetail');// Chi tiết order
Route::post('/add-order','OrderController@addOrder');// Tạo order
Route::post('/unactive-order','OrderController@unactiveOrder');// Lấy order chờ duyệt
Route::post('/active-order','OrderController@activeOrder');// Lấy order đã duyệt
Route::post('/confirm-order','OrderController@confirmOrder');// Lấy order đang giao
Route::post('/cancel-order-user','OrderController@cancelOrderUser');// Lấy order đã hủy
Route::post('/finish-order','OrderController@finishOrder');// Lấy order đã giao
Route::post('/cancel-order','OrderController@cancelOrder');// Hủy đơn hàng
Route::post('/delete-order','OrderController@deleteOrder');// Xóa order
Route::post('/update-order-user','OrderController@updateOrder');// Lấy order đã đóng gói
Route::post('/insert-order','OrderController@insertOrder');// Lấy order đã đóng gói
Route::post('return-order','OrderController@returnOrder');// Lấy order đã trả hàng
Route::post('/order-shipper', 'OrderController@orderShipper');// Lấy order đã nhập kho theo id shipper
Route::post('/receive-shipper', 'OrderController@receiveShipper');// Lấy order đang giao theo id shipper
Route::post('/get-order-receive', 'OrderController@getOrderReceive');// Lấy order đã nhập kho









// Shop
Route::post('/shop-active','ShopController@accountShopActive');// Lấy tài khoản shop đã duyệt
Route::post('/shop-unactive','ShopController@accountShopUnactive');// Lấy tài khoản shop chưa duyệt

Route::post('/show-shop','ShopController@showShop');// Lấy all thông tin shop
Route::post('/get-shop','ShopController@getShop');// Lấy all thông tin shop đã duyệt
Route::post('/unactive-shop','ShopController@unactiveShop');// Lấy all thông tin shop chờ duyệt
Route::post('/block-shop','ShopController@blockShop');// Lấy all thông tin shop đã chặn

Route::post('/cancel-shop','ShopController@cancelShop');// Chặn shop

Route::post('/detail-shop','ShopController@detailShop');// Chi tiết shop theo id
Route::post('/add-shop','ShopController@addShop');// Đăng ký shop

Route::post('/active-shop','ShopController@activeShop');// Duyệt shop

Route::post('/update-order','ShopController@updateOrder');//Đóng gói order

Route::post('/update-shop','ShopController@updateShop');// Update shop
Route::post('/delete-shop','ShopController@deleteShop');// Xóa shop

Route::post('/shop-check', 'ShopController@shopCheck');// Đã tiếp nhận order
Route::post('/shop-update', 'ShopController@shopUpdate');// Đã đóng gói order
Route::post('unactive-order-shop', 'ShopController@unactiveOrderShop');// Lấy order chưa duyệt theo shop
Route::post('active-order-shop', 'ShopController@activeOrderShop');// Lấy order đã duyệt theo shop
Route::post('update-order-shop', 'ShopController@updateOrderShop');// Lấy order đã đóng gói theo shop
Route::post('confirm-order-shop', 'ShopController@confirmOrderShop');// Lấy order đang giao theo shop
Route::post('finish-order-shop', 'ShopController@finishOrderShop');// Lấy order đã giao theo shop
Route::post('cancel-order-shop', 'ShopController@cancelOrderShop');// Lấy order đã hủy theo shop
Route::post('return-order-shop', 'ShopController@returnOrderShop');// Lấy order trả hàng theo shop
Route::post('get-order-shop', 'ShopController@getOrderShop');// Lấy order theo shop
Route::post('/insert-order-shop','ShopController@insertOrderShop');//đã nhập kho order
Route::post('/range-shop','ShopController@rangeShop');// Lấy thông tin shop để tính khoảng cách
Route::post('/active-discount', 'ShopController@activeDiscount');//Lấy sp khuyến mãi
Route::post('/unactive-discount', 'ShopController@unactiveDiscount');//Lấy sp ko khuyến mãi
Route::post('/discount','ShopController@discount');// Tạo khuyến mãi sp
Route::post('to-warehouse','ShopController@toWarehouse');// Nhập kho



Route::post('/count-product-shop','ShopController@countProductShop');// Đếm sp theo shop



 







// Comment
Route::post('/check-comment','CommentController@checkComment');// Xem người đó có mua hàng chưa để có thể comment
Route::post('/comment','CommentController@showComment');// Show all comment
Route::post('/detail-comment','CommentController@detailComment');// Lấy detail comment
Route::post('/get-comment','CommentController@getComment');// Lấy comment theo sp

Route::post('/count-comment','CommentController@countComment');// Đếm comment theo sp

Route::post('/unactive-comment-admin','CommentController@unactiveCommentAdmin');// Lấy comment chưa duyệt

Route::post('/active-comment-admin','CommentController@activeCommentAdmin');// Lấy comment đã duyệt

Route::post('/add-comment','CommentController@addComment');// Thêm comment
Route::post('/active-comment','CommentController@activeComment');// Duyệt comment
Route::post('/delete-comment','CommentController@deleteComment');// Xóa comment







// Contact
Route::post('/unactive-contact','ContactController@showUnactiveContact');// Show all contact chưa trả lời
Route::post('/active-contact','ContactController@showActiveContact');// Show all contact đã trả lời
Route::post('/reply','ContactController@reply');// Show all contact
Route::post('/add-contact','ContactController@addContact');// Thêm contact

Route::post('/delete-contact','ContactController@deleteContact');// Xóa contact








// Wishlist
Route::post('/wishlist','WishlistController@showWishlist');// Show all wishlist
Route::post('/detail-wishlist','WishlistController@detailWishlist');// Chi tiết wishlist
Route::post('/add-wishlist','WishlistController@addWishlist');// Tạo wishlist
Route::post('/get-wishlist','WishlistController@getWishlist');// Lấy wishlist
Route::post('/cart','WishlistController@cart');// Thêm vào giỏ hàng
Route::post('/delete-wishlist','WishlistController@deleteWishlist');// Xóa wishlist







// Shipper
Route::post('show-order', 'ShipperController@showOrder');// Lấy order shipper chưa nhận
Route::post('/shipper','ShipperController@showShipper');// Tài khoản shipper
Route::post('/detail-shipper','ShipperController@detailShipper');// Thông tin shipper
Route::post('/shipper-insert-order','ShipperController@shipperInsertOrder');// đã nhập kho order
Route::post('/create-order-shipper','ShipperController@createOrderShipper');// Đã lấy hàng
Route::post('/check-order-shipper','ShipperController@checkOrderShipper');// Đã nhập kho
Route::post('/take-order','ShipperController@takeOrder');// Đơn hàng đang lấy 
Route::post('/confirm-order-shipper','ShipperController@confirmOrderShipper');// Đơn hàng đang giao
Route::post('/get-order','ShipperController@getOrder');// Đang giao order
Route::post('/accept-order','ShipperController@acceptOrder');//Đã giao order
Route::post('/update-shipper','ShipperController@updateShipper');
Route::post('/delete-shipper','ShipperController@deleteShipper');
Route::post('/warehouse', 'ShipperController@warehouse');// Kho hàng giao
Route::post('/create-warehouse','ShipperController@createWarehouse');//Đơn hàng Đã lấy hàng
Route::post('/insert-warehouse', 'ShipperController@insertWarehouse');// Kho hàng nhận







// Admin
Route::post('/admin-check','AdminController@adminCheck');// Check sau khi treo order 3 ngày
Route::post('/salary-shipper','AdminController@salaryShipper');// Check đã trả lương cho shipper
Route::post('/add-user','AdminController@addUser');// Thêm tài khoản
Route::post('/update-user','AdminController@updateUser');// Update tài khoản
Route::post('/delete-user','AdminController@deleteUser');// Xóa tài khoản
Route::post('/unactive-order-admin','AdminController@unactiveOrderAdmin');// Lấy đơn hàng chưa duyệt
Route::post('/active-order-admin','AdminController@activeOrderAdmin');// Lấy đơn hàng đã duyệt
Route::post('/update-order-admin','AdminController@updateOrderAdmin');// Lấy đơn hàng đã đóng gói 
Route::post('/insert-order-admin','AdminController@insertOrderAdmin');// Lấy đơn hàng đã nhập kho
Route::post('/confirm-order-admin','AdminController@confirmOrderAdmin');// Lấy đơn hàng đang giao
Route::post('/finish-order-admin','AdminController@finishOrderAdmin');// Lấy đơn hàng đã giao
Route::post('/cancel-order-admin','AdminController@cancelOrderAdmin');// Lấy đơn hàng đã hủy
Route::post('/return-order-admin','AdminController@returnOrderAdmin');// Lấy đơn hàng đã hủy
Route::post('/final-order-admin','AdminController@finalOrderAdmin');// Lấy đơn hàng đã hoàn thành

Route::post('unactive-product-admin', 'AdminController@unactiveProductAdmin');// Lấy sản phẩm chờ duyệt
Route::post('active-product-admin', 'AdminController@activeProductAdmin');// Lấy sản phẩm đã duyệt
Route::post('block-product-admin', 'AdminController@blockProductAdmin');// Chặn sản phẩm lỗi
Route::post('confirm-product-admin', 'AdminController@confirmProductAdmin');// Duyệt sản phẩm shop đăng
Route::post('/search-unactive-product', 'AdminController@searchUnactiveProduct');// Tìm kiếm sản phẩm chưa duyệt
Route::post('/search-active-product', 'AdminController@searchActiveProduct');// Tìm kiếm sản phẩm đã duyệt
Route::post('/search-order-admin', 'AdminController@searchOrderAdmin');// Tìm kiếm order admin 








// Thống kê

Route::post('/statistic', 'AdminController@statistic');








// Bill
Route::post('/bill','AdminController@showBill');
Route::post('/add-bill','AdminController@addBill');






Route::get('/test','ProductController@test');

