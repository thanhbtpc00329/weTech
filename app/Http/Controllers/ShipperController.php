<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipper;
use App\User;
use App\Order;
use App\Notification_shipper;
use DB;

class ShipperController extends Controller
{
    //Shipper
    public function showShipper()
    {
    	$ship = User::where('role','Shipper')->paginate(10);
        return response()->json($ship);
    }

    public function detailShipper(){
    	$ship = DB::table('shippers')
    			->join('users','users.user_id','=','shippers.user_id')
                ->where('users.role','=','Shipper')
    			->paginate(10);
    	return response()->json($ship);
    }

    // Order

    public function showOrder(){
        $show = Order::where('shipper_deliver',null)->where('shipper_receive',null)->paginate(10);

        return response()->json($show);
    }

    public function shipperInsertOrder(Request $request){
        $id = $request->id; 
        $shipper_deliver = $request->shipper_deliver;

        $order = Order::find($id);
        $order->shipper_deliver = $shipper_deliver;
        $order->status = 'Đang lấy hàng';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }


    public function checkOrderShipper(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã nhập kho';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }



    public function createOrderShipper(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã lấy hàng';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }




    public function getOrder(Request $request){
        $id = $request->id; 
        $shipper_receive = $request->shipper_receive;

        $order = Order::find($id);
        $order->shipper_receive = $shipper_receive;
        $order->status = 'Đang giao';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }

    public function acceptOrder(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã giao';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }

    public function insertWarehouse(Request $request)
    {
        $keywords = $request->keywords;

        $ship = DB::table('orders')
                ->join('shops','shops.shop_id','=','orders.shop_id')
                ->where('orders.order_address','like','%'.$keywords.'%')
                ->where('orders.status','=','Đã đóng gói')
                ->select('orders.id','orders.user_id','orders.order_address','orders.status','orders.shipping','orders.user_range','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.order_detail','shops.shop_name','shops.shop_address','shops.location','shops.shop_range','shops.phone_number')
                ->get();
        return response()->json($ship);
    }

     public function createWarehouse(Request $request)
    {
        $shipper_deliver = $request->shipper_deliver;

        $ship = DB::table('orders')
                ->join('shops','shops.shop_id','=','orders.shop_id')
                ->where('orders.status','=','Đã lấy hàng')
                ->where('orders.shipper_deliver','=',$shipper_deliver)
                ->select('orders.id','orders.user_id','orders.order_address','orders.status','orders.shipping','orders.user_range','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.order_detail','shops.shop_name','shops.shop_address','shops.location','shops.shop_range','shops.phone_number')
                ->get();
        return response()->json($ship);
    }

    public function warehouse(Request $request)
    {
        $keywords = $request->keywords;

        $ship = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->join('shops','shops.shop_id','=','orders.shop_id')
                ->where('orders.status','=','Đã nhập kho')
                ->select('orders.id','orders.user_id','orders.order_address','orders.status','orders.shipping','orders.user_range','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.order_detail','shops.shop_name','shops.shop_address','shops.location','shops.shop_range','shops.phone_number')
                ->get();
        return response()->json($ship);
    }

    public function takeOrder(Request $request)
    {
        $shipper_deliver = $request->shipper_deliver;

        $ship = DB::table('orders')
                ->join('shops','shops.shop_id','=','orders.shop_id')
                ->where('orders.status','=','Đang lấy hàng')
                ->where('orders.shipper_deliver',$shipper_deliver)
                ->select('orders.id','orders.user_id','orders.order_address','orders.status','orders.shipping','orders.user_range','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.order_detail','shops.shop_name','shops.shop_address','shops.location','shops.shop_range','shops.phone_number')
                ->get();
        return response()->json($ship);
    }


    public function confirmOrderShipper(Request $request)
    {
        $shipper_receive = $request->shipper_receive;

        $ship = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shipper_receive','=',$shipper_receive)
                ->where('orders.status','=','Đang giao')
                ->select('orders.id','orders.user_id','orders.order_address','orders.status','orders.shipping','orders.user_range','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.order_detail','users.name','users.username','users.email','users.gender','users.address','users.phone_number','users.avatar','users.birth_day')
                ->get();
        return response()->json($ship);
    }





    // Notification
    public function addNotificationShipper(Request $request){
        $order_id = $request->order_id;
        $message = $request->message;
        $type = $request->type;

        $tb = new Notification_shipper;
        $tb->order_id = $order_id;
        $tb->message = $message;
        $tb->type = $type;
        $tb->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $tb->save();
        
        if ($tb) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }


    public function deleteNotificationShipper(Request $request){
        $id = $request->id;

        $tb = Notification_shipper::find($id);
        $tb->delete();
        
        if ($tb) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }

}
