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

    public function showShop(){
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
        $shop_name = $request->shop_name;
        $user_id = $request->user_id;
        $identity_card = $request->identity_card;
        $address = $request->address;
        $location = $request->location;
        $phone_number = $request->phone_number;

        $shop = new Shop;
        $shop->shop_name = $shop_name;
        $shop->user_id = $user_id;
        $shop->identity_card = $identity_card;
        $shop->address = $address;
        $shop->location = $location;
        $shop->phone_number = $phone_number;
        $shop->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $shop->save();

        
        if ($shop) {
            return response()->json(['success' => 'Đăng ký thành viên thành công!']);  
        }
        else{
            return response()->json(['error' => 'Đăng ký thành viên thất bại']);
        }  
    }

    public function activeShop(Request $request){
        $user_id = $request->user_id;

        $mem = User::where('user_id',$user_id)->update(['role' => 'Member']);
        return response()->json($mem);
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
            return response()->json(['success' => 'Cập nhật thành công!']);  
        }
        else{
            return response()->json(['error' => 'Cập nhật thất bại']);
        }  
    }

    public function deleteShop(Request $request){
        $id = $request->shop_id;

        $shop = Shop::where('shop_id',$id)->delete();
        if ($shop) {
            return response()->json(['success' => 'Xóa thành công!']);  
        }
        else{
            return response()->json(['error' => 'Xóa thất bại']);
        }  
    }
}
