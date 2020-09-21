<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
use App\Banner;
use App\Shipper;
use App\Shop;
use App\Bill;
use Response,File;


class AdminController extends Controller
{
    
    // Bill
    public function showBill(){
        return Bill::all();
    }

    public function addBill(Request $request){
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $total = $request->total;

        $bill = new Bill;

        $bill->name = $name;
        $bill->username = $username;
        $bill->email = $email;
        $bill->total = $total;
        $bill->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $bill->save();
        if ($bill) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }



    // Shop
    public function showShop()
    {
        return Shop::all();
    }

    public function addShop(Request $request){
        $name = $request->name;
        $address = $request->address;
        $location = $request->location;
        $phone_number = $request->phone_number;

        $shop = new Shop;
        $shop->name = $name;
        $shop->address = $address;
        $shop->location = $location;
        $shop->phone_number = $phone_number;
        $shop->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $shop->save();
        if ($shop) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
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
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function deleteShop(Request $request){
        $id = $request->shop_id;

        $shop = Shop::where('shop_id',$id)->delete();
        if ($shop) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }



    public function showShipper()
    {
        return Shipper::all();
    }

    
    


}
