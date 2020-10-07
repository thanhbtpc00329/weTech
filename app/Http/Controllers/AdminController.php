<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
use App\Shop;
use App\Bill;
use App\Order;
use App\Shipper;
use Response,File;
use DB;


class AdminController extends Controller
{
    // Order
    public function adminCheck(Request $request){
        $shipper_id = $request->shipper_id; 

        $ship = Shipper::where('shipper_id',$shipper_id)->first();

        $order = Shipper::where('shipper_id',$shipper_id)->update(['order_quantity' => $ship->order_quantity + 1]);
        if ($ship->order_quantity > 19) {
            $ship = Shipper::where('shipper_id',$shipper_id)->update([
            'salary' => 4000000,
            'status' => 1,
            'updated_at' => now()->timezone('Asia/Ho_Chi_Minh'),
            ]);
        }
        
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }


    public function salaryShipper(Request $request){
        $shipper_id = $request->shipper_id; 

        $ship = Shipper::where('shipper_id',$shipper_id)->update([
            'salary' => 0,
            'status' => 0,
            'updated_at' => now()->timezone('Asia/Ho_Chi_Minh'),
        ]);

        if ($ship) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }

    
    // Bill
    public function showBill(){
        return Bill::all();
    }

    public function addBill(Request $request){
        $product_id = $request->product_id;
        $sale_amount = $request->sale_amount;
        $status = $request->status;

        $bill = new Bill;

        $bill->product_id = $product_id;
        $bill->sale_amount = $sale_amount;
        $bill->status = $status;
        $bill->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $bill->save();
        if ($bill) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }



        
    


}
