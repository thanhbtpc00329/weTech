<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;

class WishlistController extends Controller
{
    // Wishlist
    public function showWishlist()
    {
        return Wishlist::all();
    }

    public function addWishlist(Request $request){
        $username = $request->username;
        $product_name = $request->product_name;
        $product_image = $request->product_image;
        $product_id = $request->product_id;

        $wishlist = new Wishlist;
        $wishlist->username = $username;
        $wishlist->product_name = $product_name;
        $wishlist->product_image = $product_image;
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
