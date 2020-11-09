<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Cart_detail;
use App\Product_detail;
use DB;
use Response;

class CartController extends Controller
{

	public function getCart(Request $request){
		$user_id = $request->user_id;

		$cart1 = DB::table('carts')
				->join('cart_detail','carts.cart_id','=','cart_detail.cart_id')
				->join('product_detail','cart_detail.prodetail_id','=','product_detail.prodetail_id')
				->join('products','product_detail.product_id','=','products.product_id')
				->join('users','users.user_id','=','carts.user_id')
				->join('shops','shops.shop_id','=','cart_detail.shop_id')
				->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            	->groupby('product_image.prodetail_id')
				->where('carts.user_id','=',$user_id)
				->select('products.product_id','products.product_name','products.introduction','products.description','products.tag','products.brand','product_detail.prodetail_id','product_detail.price','product_detail.color','cart_detail.cart_quantity','product_detail.size','product_detail.discount_price','product_detail.status_discount','product_image.image','shops.shop_id','shops.shop_name','shops.shop_address','shops.phone_number','product_detail.origin','product_detail.accessory','product_detail.dimension','product_detail.weight','product_detail.system','product_detail.material','product_detail.screen_size','product_detail.wattage','product_detail.resolution','product_detail.memory','users.avatar')
				->get();

		
		return response()->json($cart1);
	}


 	public function addCart(Request $request){
 		$ch1 = '01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $ch1len = strlen($ch1);
            $rd = '';
            for ($i = 0; $i < 2; $i++) {
                $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
            }
        $id = 'Cart_'.$rd;
        $time = now()->timezone('Asia/Ho_Chi_Minh');
        $prodetail_id = $request->prodetail_id;
        $user_id = $request->user_id;
        $shop_id = $request->shop_id;
        $cart_quantity = $request->cart_quantity;
        $cart = new Cart;
        $cart->cart_id = $id;
        $cart->user_id = $user_id;
        $cart->created_at = $time;

        $cart->save();

        $cart_detail = new Cart_detail;
        $cart_detail->cart_id = $id;
        $cart_detail->prodetail_id = $prodetail_id;
        $cart_detail->shop_id = $shop_id;
        $cart_detail->cart_quantity = $cart_quantity;
        $cart_detail->created_at = $time;
        $cart_detail->save();

        $pro = Product_detail::where('prodetail_id',$prodetail_id)->first();
        $pro->quantity = ($pro->quantity - $cart_quantity);
        $pro->save();

        if ($cart_detail) {
            return response()->json(['success' => 'Thêm sản phẩm vào giỏ hàng thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thêm sản phẩm vào giỏ hàng thất bại']);
        }

 	}


}
