<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Cart;
use App\Cart_detail;
use App\Shipper;

class OrderController extends Controller
{
    // Order
    public function showOrder()
    {
        return Order::all();
    }


    public function orderDetail(Request $request){
        $user_id = $request->user_id;

        $order = Order::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
        return $order;
    }
    

    public function addOrder(Request $request){
        $user_id = $request->user_id;
        $address = $request->address;
        $shipping = $request->shipping;
        $total = $request->total;
        $add = $request->order_detail;
        $tt = ltrim($add,"'");
        $rr = rtrim($tt,"'");
        $arr = json_decode($rr);
        $kq = array();
        for ($i=0; $i < count($arr); $i++) { 
            $re = $arr[$i]->shop_id;
            if (in_array($re,$kq) == false) {
                array_push($kq,$re);
            }
        }
        foreach ($arr as $value) {
            $group[$value->shop_id][] = $value;       
        }
        $time = now()->timezone('Asia/Ho_Chi_Minh');

        $cart = Cart::where('user_id',$user_id)->delete();
        // $cart_detail = Cart_detail::where('cart_id',$cart)->get();
        // $cart_detail->delete();
        
        for ($i=0; $i < count($group); $i++) { 
            $order_detail = $group[$kq[$i]];

            $order = new Order;
            $order->user_id = $user_id;
            $order->address = $address;
            $order->shipping = $shipping;
            $order->total = $total;
            $order->shop_id = $kq[$i];
            $order->status = 'Chờ duyệt';
            $order->order_detail = json_encode($order_detail);
            $order->created_at = $time;

            $order->save();
        }


       
        if ($order) {
            return response()->json(['success' => 'Thanh toán thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thanh toán bị lỗi']);
        }

    }

    public function activeOrder(Request $request){
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

    public function confirmOrder(Request $request){
        $id = $request->id; 
        $shipper_id = $request->shipper_id;
        $order = Order::find($id);
        $order->shipper_id = $shipper_id;
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

    public function finishOrder(Request $request){
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

    public function acceptOrder(Request $request){
        $shipper_id = $request->shipper_id; 
        $ship = Shipper::find($shipper_id);
        if ($ship->order_quantity == 0) {
            $ship->order_quantity = 1;
        }elseif(0 < $ship->order_quantity < 20){
            $ship->order_quantity += 1;
        }else{
            $ship->salary = 4000000;
            $ship->status = 1;
        }
        
        $ship->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $ship->save();
        if ($ship) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }

    public function deleteOrder(Request $request){
        $id = $request->id;  

        $order = Order::find($id);

        $order->delete();
        if ($order) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

}
