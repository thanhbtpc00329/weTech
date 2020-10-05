<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
use App\Shop;
use App\Bill;
use App\Order;
use Response,File;
use DB;


class AdminController extends Controller
{
    // Order
    public function adminCheck(Request $request){
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
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }



        
    


}
