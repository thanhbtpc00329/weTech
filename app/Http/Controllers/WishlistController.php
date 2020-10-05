<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use DB;
use App\Cart;
use App\Cart_detail;

class WishlistController extends Controller
{
    // Wishlist
    public function showWishlist()
    {
        return Wishlist::all();
    }


    public function detailWishlist(){
        $wish = DB::table('wishlists')
                ->join('users','users.user_id','=','wishlists.user_id')
                ->join('products','products.product_id','=','wishlists.product_id')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
                ->groupBy('product_detail.product_id')
                ->get();
        return response()->json($wish);
    }


    public function addWishlist(Request $request){
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        $wishlist = new Wishlist;
        $wishlist->user_id = $user_id;
        $wishlist->product_id = $product_id;
        $wishlist->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $wishlist->save();
        if ($wishlist) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }


    public function cart(Request $request){
        $id = $request->id;

        $wish = DB::table('wishlists')
                ->join('users','users.user_id','=','wishlists.user_id')
                ->join('products','products.product_id','=','wishlists.product_id')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
                ->where('wishlists.id',$id)
                ->groupBy('product_detail.product_id')
                ->get();
        $ch1 = '01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $ch1len = strlen($ch1);
            $rd = '';
            for ($i = 0; $i < 2; $i++) {
                $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
            }
        $cart_id = 'Cart_'.$rd;
        $time = now()->timezone('Asia/Ho_Chi_Minh');
        foreach ($wish as $value) {
            $cart = new Cart;
            $cart->cart_id = $cart_id;
            $cart->user_id = $value->user_id;
            $cart->created_at = $time;

            $cart->save();

            $cart_detail = new Cart_detail;
            $cart_detail->cart_id = $cart_id;
            $cart_detail->prodetail_id = $value->prodetail_id;
            $cart_detail->shop_id = $value->shop_id;
            $cart_detail->cart_quantity = 1;
            $cart_detail->created_at = $time;
            $cart_detail->save();
        }

        $del = Wishlist::find($id);
        $del->delete();
        if ($del) {
            return response()->json(['success' => 'Thêm sản phẩm vào giỏ hàng thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thêm sản phẩm vào giỏ hàng thất bại']);
        }
        
    }



    public function deleteWishlist(Request $request){
        $id = $request->id;

        $wishlist = Wishlist::find($id);
        $wishlist->delete();
        if ($wishlist) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }
}
