<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Shop;
use App\Order;
use DB;


class ShopController extends Controller
{
    // Shop
    public function accountShopActive()
    {
        $shop = User::where('role','Member')->where('status',1)->get();
        return response()->json($shop);
    }

    public function accountShopUnactive()
    {
        $shop = User::where('role','Member')->where('status',0)->get();
        return response()->json($shop);
    }

    public function showShop(){
    	$shop = DB::table('shops')
    			->join('users','users.user_id','=','shops.user_id')
    			->get();
    	return response()->json($shop);
    }

    public function getShop(){
        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->where('shops.status','=',1)
                ->get();
        return response()->json($shop);
    }  

    public function unactiveShop(){
        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->where('shops.status','=',0)
                ->get();
        return response()->json($shop);
    }    

    public function blockShop(){
        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->where('shops.status','=',2)
                ->get();
        return response()->json($shop);
    } 

    public function detailShop(Request $request){
        $shop_id = $request->id;

        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->select('shops.shop_id','shops.shop_name','shops.shop_address','shops.phone_number','shops.background','shops.shop_range','shops.location','shops.tax','users.avatar')
                ->where('shop_id','=',$shop_id)
                ->get();
        return response()->json($shop);
    }


    public function rangeShop(Request $request){
        $shop_id = $request->shop_id;

        $shop = Shop::where('shop_id','=',$shop_id)->first();
        return response()->json($shop);
    }



    public function addShop(Request $request){
        $shop_name = $request->shop_name;
        $user_id = $request->user_id;
        $identity_card = $request->identity_card;
        $shop_address = $request->shop_address;
        $location = $request->location;
        $shop_range = $request->shop_range;
        $phone_number = $request->phone_number;
        $tax = $request->tax;

        $shop = new Shop;
        $shop->shop_name = $shop_name;
        $shop->user_id = $user_id;
        $shop->identity_card = $identity_card;
        $shop->shop_address = $shop_address;
        $shop->location = $location;
        $shop->shop_range = $shop_range;
        $shop->phone_number = $phone_number;
        $shop->tax = $tax;
        $shop->status = '0';
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
        $shop_id = $request->shop_id;
        $user_id = $request->user_id;
        $shop = Shop::where('shop_id',$shop_id)->update(['status' => 1]);
        $mem = User::where('user_id',$user_id)->update(['role' => 'Member']);
        if ($mem) {
            return response()->json(['success' => 'Kích hoạt thành viên thành công!']);  
        }
        else{
            return response()->json(['error' => 'Kích hoạt thành viên thất bại']);
        }
    }


    public function cancelShop(Request $request){
        $shop_id = $request->shop_id;
        $user_id = $request->user_id;
        $shop = Shop::where('shop_id',$shop_id)->update(['status' => 2]);
        $mem = User::where('user_id',$user_id)->update(['role' => 'User']);
        if ($mem) {
            return response()->json(['success' => 'Chặn thành viên thành công!']);  
        }
        else{
            return response()->json(['error' => 'Chặn thành viên thất bại']);
        }
    }


    public function updateShop(Request $request){
        $id = $request->shop_id;
        $name = $request->name;
        $shop_address = $request->shop_address;
        $location = $request->location;
        $shop_range = $request->shop_range;
        $phone_number = $request->phone_number;
        $status = $request->status;
        $tax = $request->tax;

        $shop = Shop::where('shop_id',$id)->update([
            'name'=>$name,
            'address'=>$address,
            'location'=>$location,
            'shop_range'=>$shop_range,
            'phone_number'=>$phone_number,
            'tax' => $tax,
            'status'=>$status,
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

    // Order
    public function updateOrder(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã đóng gói';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }


    // Order

    public function getOrderShop(Request $request){
        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function unactiveOrderShop(Request $request){
        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Chờ duyệt')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function activeOrderShop(Request $request){
        $shop_id = $request->shop_id;

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Đã duyệt')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function updateOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Đã đóng gói')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }


    public function confirmOrderShop(Request $request){
        
        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Đang giao')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function finishOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Đã giao')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function cancelOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Đã hủy')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function returnOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Trả hàng')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function insertOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id',$shop_id)
                ->where('orders.status','Nhập kho')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_id','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar')
                ->get();
        return response()->json($order);
    }

    public function shopCheck(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã duyệt';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }

    public function shopUpdate(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã đóng gói';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }
}
