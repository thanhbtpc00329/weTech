<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Shop;
use DB;


class ShopController extends Controller
{
    // Shop
    public function accountShop()
    {
        $shop = User::where('role','Member')->get();
        return response()->json($shop);
    }

    public function showShop(Request $request){
    	$shop = DB::table('shops')
    			->join('users','users.user_id','=','shops.user_id')
    			->get();
    	return response()->json($shop);
    }

    public function detailShop(Request $request){
        $shop_id = $request->id;

        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->select('shops.shop_id','shops.shop_name','shops.address','shops.phone_number','shops.background','users.avatar')
                ->where('shop_id','=',$shop_id)
                ->get();
        return response()->json($shop);
    }

    public function addShop(Request $request){
        $name = $request->name;
        $address = $request->address;
        $location = $request->location;
        $phone_number = $request->phone_number;

        $shop = new Shop;
        $shop->name = $name;
        $shop->address = $address;
        $shop->location = $location;
        $shop->phone_number = $phone_number;
        $shop->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $shop->save();
        if ($shop) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function updateShop(Request $request){
        $id = $request->shop_id;
        $name = $request->name;
        $address = $request->address;
        $location = $request->location;
        $phone_number = $request->phone_number;

        $shop = Shop::where('shop_id',$id)->update([
            'name'=>$name,
            'address'=>$address,
            'location'=>$location,
            'phone_number'=>$phone_number,
            'updated_at'=>now()->timezone('Asia/Ho_Chi_Minh')
        ]);

        if ($shop) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function deleteShop(Request $request){
        $id = $request->shop_id;

        $shop = Shop::where('shop_id',$id)->delete();
        if ($shop) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }
}
