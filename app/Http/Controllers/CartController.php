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
				->join('cart_detail','carts.cart_id','=','cart_detail.cart_id')
				->join('product_detail','cart_detail.prodetail_id','=','product_detail.prodetail_id')
				->join('products','product_detail.product_id','=','products.product_id')
				->join('users','users.user_id','=','carts.user_id')
				->join('shops','shops.shop_id','=','cart_detail.shop_id')
				->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            	->groupby('product_image.prodetail_id')
				->where('carts.user_id','=',$user_id)
				->select('products.product_id','products.product_name','products.introduction','products.description','products.tag','products.brand','product_detail.prodetail_id','product_detail.price','product_detail.color','cart_detail.cart_quantity','product_detail.size','product_detail.discount_price','product_detail.status','product_image.image','shops.shop_id','shops.shop_name','shops.address','shops.phone_number','product_detail.origin','product_detail.accessory','product_detail.dimension','product_detail.weight','product_detail.system','product_detail.material','product_detail.screen_size','product_detail.wattage','product_detail.resolution','product_detail.memory','users.avatar','carts.created_at')
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
  //       $cart = $request->cart;
		// $arr = json_decode($cart);
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

        if ($cart_detail) {
        	echo "Thành công";
        }
        else{
        	echo "Thất bại";
        }

 	}








 // 	public function Cart(Request $request){
	// 	$user_id = $request->user_id;

	// 	$cart1 = DB::table('carts')
	// 			->join('cart_detail','carts.cart_id','=','cart_detail.cart_id',)
	// 			->join('product_detail','cart_detail.prodetail_id','=','product_detail.prodetail_id')
	// 			->join('users','users.user_id','=','carts.user_id')
	// 			->join('shops','shops.shop_id','=','cart_detail.shop_id')
	// 			->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
 //            	->groupby('product_image.prodetail_id')
	// 			->where('carts.user_id','=',$user_id)
	// 			->select('cart_detail.shop_id','cart_detail.prodetail_id','product_image.image','shops.shop_name')
	// 			->get();
	// 	$cart3 = DB::table('carts')
	// 			->join('cart_detail','carts.cart_id','=','cart_detail.cart_id',)
	// 			->join('shops','shops.shop_id','=','cart_detail.shop_id')
	// 			->where('carts.user_id','=',$user_id)
	// 			->select('cart_detail.shop_id','shops.shop_name')
	// 			->distinct()
	// 			->get();
	// 	$kr = array();
	// 	$tr = array();
		
		
	// 	$uu = array();
	// 	for ($i=0; $i < count($cart3); $i++) { 
	// 		$cart5 = Cart_detail::where('shop_id',$cart3[$i]->shop_id)->get();
	// 		for ($j=0; $j < count($cart5); $j++) { 
	// 			$cart2 = DB::table('product_detail')
 //            ->join('products','product_detail.product_id','=','products.product_id')
 //            ->join('shops','shops.shop_id','=','products.shop_id')
 //            ->where('product_detail.prodetail_id','=',$cart1[$j]->prodetail_id)
 //            ->where('product_detail.shop_id','=',$cart3[$i]->shop_id)
            
 //            ->get();
            
 //            	array_push($tr,$cart2);
	// 		}
			
	// 		$kq = array(
	// 			'shop_name' => $cart3[$i]->shop_name,
	// 			'product_in_shop'=>$tr
	// 			); 
	// 			array_push($kr,$kq);
	// 		array_splice($tr,0,$j);
	// 	}
		
	// 	// $str1 = json_encode($kr);
	// 	// $str2 = str_replace(array('[[',']]','],['),array('[',']',','),$str1);
	// 	// $str3 = json_decode($str2);
	// 	return $kr;
	// }   
}
