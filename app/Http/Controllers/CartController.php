<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Cart_detail;
use DB;
use Response;

class CartController extends Controller
{

	public function getCart(Request $request){
		$user_id = $request->user_id;

		$cart1 = DB::table('carts')
				->join('cart_detail','carts.cart_id','=','cart_detail.cart_id',)
				->join('product_detail','cart_detail.prodetail_id','=','product_detail.prodetail_id')
				->join('users','users.user_id','=','carts.user_id')
				->join('shops','shops.shop_id','=','cart_detail.shop_id')
				->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            	->groupby('product_image.prodetail_id')
				->where('carts.user_id','=',$user_id)
				->select('shops.shop_name','cart_detail.prodetail_id','product_image.image')
				->get();
		$kr=array();
		for ($i=0; $i < count($cart1); $i++) { 
			$cart2 = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->where('product_detail.prodetail_id','=',$cart1[$i]->prodetail_id)
            ->get();
            if ($cart2) {
            	array_push($kr,$cart2); 	
            }
		}
		$kq = [
			'shop_name' => $cart1[0]->shop_name,
			'product_in_shop'=>$kr
		];
		$str1 = json_encode($kq);
		$str2 = str_replace(array('[[',']]','],['),array('[',']',','),$str1);
		$str3 = json_decode($str2);
		return response()->json($str3);
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
        $cart = $request->cart;
        $arr = json_decode($cart);
        for ($i=0; $i < count($arr); $i++) { 
        	$user = $arr[$i]->user_id;
        	$shop = $arr[$i]->shop_id;
        }
        $user_id = $user;
        $shop_id = $shop;
        $cart = new Cart;
        $cart->cart_id = $id;
        $cart->user_id = $user_id;
        $cart->created_at = $time;

        $cart->save();

        for ($i=0; $i < count($arr); $i++) { 

        	$cart_detail = new Cart_detail;
        	$cart_detail->cart_id = $id;
        	$cart_detail->prodetail_id = $arr[$i]->prodetail_id;
        	$cart_detail->shop_id = $shop_id;
        	$cart_detail->created_at = $time;
        	$cart_detail->save();
        }

        if ($cart_detail) {
        	echo "Thành công";
        }
        else{
        	echo "Thất bại";
        }

 	}   
}
