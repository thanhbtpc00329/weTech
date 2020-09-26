<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    // Order
    public function showOrder()
    {
        return Order::all();
    }

    public function addOrder(Request $request){
        $username = $request->username;
        $address = $request->address;
        $shipping = $request->shipping;
        $total = $request->total;
        $status = $request->status;
        $cart = $request->order_detail;
        $tt = ltrim($cart,"'");
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
        
        for ($i=0; $i < count($group); $i++) { 
            $order_detail = $group[$kq[$i]];

            $order = new Order;
            $order->username = $username;
            $order->address = $address;
            $order->shipping = $shipping;
            $order->total = $total;
            $order->shop = $kq[$i];
            $order->status = $status;
            $order->order_detail = json_encode($order_detail);
            $order->created_at = $time;

            $order->save();
        }
        
       
        if ($order) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    public function updateOrder(Request $request){
        $id = $request->id;
        $status = $request->status;  

        $order = Order::find($id);
        $order->status = $status;
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
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
