<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipper;
use App\User;
use App\Order;
use DB;

class ShipperController extends Controller
{
    //Shipper
    public function showShipper()
    {
    	$ship = User::where('role','Shipper')->get();
        return response()->json($ship);
    }

    public function detailShipper(){
    	$ship = DB::table('shippers')
    			->join('users','users.user_id','=','shippers.user_id')
    			->get();
    	return response()->json($ship);
    }

    // Order
    public function getOrder(Request $request){
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
}
