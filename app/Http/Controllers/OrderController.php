<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facases\Http;
use App\Order;
use App\Cart;
use App\Cart_detail;
use App\Shipper;
use DB;
use GuzzleHttp;

class OrderController extends Controller
{
    // Order
    public function showOrder()
    {
        $order = DB::table('orders')
                ->join('shops','orders.shop_id','=','shops.shop_id')
                ->select('orders.id','orders.user_id','orders.shop_id','orders.order_address','orders.shipping','orders.total','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','orders.updated_at','shops.shop_name','shops.location','shops.phone_number','shops.shop_address')
                ->get();
        return response()->json($order);
    }


    public function showOrderShipper()
    {
        $order = DB::table('orders')
                ->join('shops','orders.shop_id','=','shops.shop_id')
                ->select('orders.id','orders.user_id','orders.shop_id','orders.order_address','orders.shipping','orders.total','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','orders.updated_at','shops.shop_name','shops.location','shops.phone_number','shops.shop_address')
                ->where('shipper_deliver','=',null)
                ->where('orders.status','=','Đã đóng gói')
                ->get();
        return response()->json($order);
    }


    public function getOrderReceive()
    {
        $order = DB::table('orders')
                ->join('users','orders.user_id','=','users.user_id')
                ->select('orders.id','orders.user_id','orders.shop_id','orders.order_address','orders.shipping','orders.total','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','orders.updated_at','users.username','users.address','users.phone_number','users.name','users.email','users.user_id','users.gender')
                ->where('shipper_receive','=',null)
                ->where('orders.status','=','Đã nhập kho')
                ->get();
        return response()->json($order);
    }


    public function orderDetail(Request $request){
        $user_id = $request->user_id;

        $order = DB::table('orders')
            ->join('shops','shops.shop_id','orders.shop_id')
            ->where('orders.user_id','=',$user_id)
            ->groupBy('orders.created_at')
            ->orderBy('orders.created_at','DESC')
            ->get();
        return response()->json($order);
    }

    
    
    public function addOrder(Request $request){
        $user_id = $request->user_id;
        $order_address = $request->order_address;
        $shipping = $request->shipping;
        $pp = ltrim($shipping,"'");
        $kk = rtrim($pp,"'");
        $uu = json_decode($kk);
        $total = $request->total;
        $add = $request->order_detail;
        $user_range = $request->user_range;
        $weight = $request->weight_order;
        $note = $request->note;
        $ship_price = $request->ship_price;
        $payment = $request->payment;
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
        
        for ($i=0; $i < count($group); $i++) { 
            $order_detail = $group[$kq[$i]];
            

            $order = new Order;
            $order->user_id = $user_id;
            $order->order_address = $order_address;
            if($weight){
                $order->shipping = ($ship_price / count($group)); 
            }else{
                $order->shipping = 0;
            }
        
            if($user_range){
                $order->user_range = $user_range;
            }
            $order->total = $total;
            $order->shop_id = $kq[$i];
            $order->status = 'Chờ duyệt';
            $order->order_detail = json_encode($order_detail);
            if (isset($note) && isset($payment)) {
                $order->note = '- Yêu cầu: ' .$note.'. Đơn hàng đã được thanh toán bằng '.$payment;
            }else{
                $order->note = $note;
            }
            $order->created_at = $time;

            $order->save();
            
        }
        if($order){
            return response()->json(['success' => 'Thanh toán thành công!']);
        }
        else{
            return response()->json(['error' => 'Thanh toán bị lỗi']);
        }
        
    }

    public function unactiveOrder(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Chờ duyệt')->orderBy('created_at','DESC')->get();
        return response()->json($order);
    }

    public function activeOrder(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Đã duyệt')->orderBy('created_at','DESC')->get();
        return response()->json($order);
    }


    public function confirmOrder(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Đang giao')->orderBy('created_at','DESC')->get();
        return response()->json($order);
    }

    public function finishOrder(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Đã giao')->get();
        return response()->json($order);
    }

    public function cancelOrderUser(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Đã hủy')->get();
        return response()->json($order);
    }


    public function updateOrder(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Đã đóng gói')->get();
        return response()->json($order);   
    }


    public function returnOrder(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Trả hàng')->get();
        return response()->json($order);   
    }


    public function orderShipper(Request $request)
    {
        $shipper_deliver = $request->shipper_deliver; 

        $order = DB::table('orders')
                ->join('shops','shops.shop_id','=','orders.shop_id')
                ->where('orders.shipper_deliver','=',$shipper_deliver)
                ->where('orders.status','=','Đã nhập kho')
                ->get();
        return response()->json($order);
    }


    public function receiveShipper(Request $request)
    {
        $shipper_receive = $request->shipper_receive; 

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shipper_receive','=',$shipper_receive)
                ->where('orders.status','=','Đang giao')
                ->get();
        return response()->json($order);
    }


    public function insertOrder(Request $request){
        $user_id = $request->user_id; 

        $order = Order::where('user_id',$user_id)->where('status','Đã nhập kho')->get();
        return response()->json($order);   
    }


    public function deleteOrder(Request $request){
        $id = $request->id;  

        $order = Order::find($id);

        $order->delete();
        if ($comment) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }

    }

    public function cancelOrder(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã hủy';
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
