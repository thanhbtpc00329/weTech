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
        $arr = json_decode($cart);

        $time = now()->timezone('Asia/Ho_Chi_Minh');
        $group = array();
        foreach ($arr as $value) {
            $group[$value->shop_id][] = $value;   
                
        }
        // for ($i=0; $i < count($group); $i++) { 
        //     $order_detail = $group[$i];
        // }
        
        return $group;

        // $order = new Order;
        // $order->username = $username;
        // $order->address = $address;
        // $order->shipping = $shipping;
        // $order->total = $total;
        // $order->status = $status;
        // $order->order_detail = $order_detail;
        // $order->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        // $order->save();
        // if ($order) {
        //     echo 'Thành công';
        // }
        // else{
        //     echo 'Lỗi';
        // }

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
