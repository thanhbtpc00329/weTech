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


    // User
    public function showUser(){
        $user = User::where('role','User')->get();
        return $user;
    }

    public function addUser(Request $request){
        $ch1 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ch1len = strlen($ch1);
        $rd = '';
        for ($i = 0; $i < 4; $i++) {
            $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
        }
        $id = abs(crc32($rd));
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $gender = $request->gender;
        $address = $request->address;
        $birth_day = $request->birth_day;
        $phone_number = $request->phone_number;
        $avatar = $request->avatar;
        $role = $request->role;
        $background = $request->background;


        $account = new User;
        $account->user_id = $id;
        $account->name=$name;
        $account->username=$username;
        $account->email=$email;
        $account->password=Hash::make($password);
        $account->gender=$gender;
        $account->address=$address;
        $account->birth_day=$birth_day;
        $account->phone_number=$phone_number;
        if ($request->hasFile('avatar')) {
            //get name image
            $filename = $request->file('avatar');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut1 = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut1);
            list($width, $height) = getimagesize($filename);         
            $account->avatar = Cloudder::show('users/'. $cut1, ['width'=>$width,'height'=>$height]); 

        }

        if ($request->hasFile('background')) {
            //get name image
            $filename1 = $request->file('background');
            $name1 = $filename1->getClientOriginalName();
            $extension1 = $filename1->getClientOriginalExtension();
            $cut2 = substr($name1, 0,strlen($name1)-(strlen($extension1)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut2);    
            list($width, $height) = getimagesize($filename1);        
            $account->background = Cloudder::show('users/'. $cut2, ['width'=>$width,'height'=>$height]);    
        }
        $account->status=1;
        $account->role = $role;
        $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();
        if($role == 'Shipper'){
            $ship = new Shipper;
            $ship->user_id = $id;
            $ship->order_quantity = 0;
            $ship->salary = 0;
            $ship->status = 0;
            $ship->created_at = now()->timezone('Asia/Ho_Chi_Minh');    
            $ship->save();
        }
        if ($account) {
            return response()->json(['success' => 'Tạo tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Tạo tài khoản thất bại']);
        }

    }


    public function updateUser(Request $request){
        $user_id = $request->user_id;
        $name = $request->name;
        $password = $request->password;
        $gender = $request->gender;
        $address = $request->address;
        $birth_day = $request->birth_day;
        $phone_number = $request->phone_number;
        $avatar = $request->avatar;
        $role = $request->role;
        $background = $request->background;
        $status = $request->status;
        

        

        $account = User::where('user_id',$user_id)->first();
        $account->name=$name;
        $account->password=Hash::make($password);
        $account->gender=$gender;
        $account->address=$address;
        $account->birth_day=$birth_day;
        $account->phone_number=$phone_number;
        if ($request->hasFile('avatar')) {
            //get name image
            $filename = $request->file('avatar');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut1 = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut1); 
            list($width, $height) = getimagesize($filename);
            $account->avatar = Cloudder::show('users/'. $cut1, ['width'=>$width,'height'=>$height]);       
        }

        if ($request->hasFile('background')) {
            //get name image
            $filename1 = $request->file('background');
            $name1 = $filename1->getClientOriginalName();
            $extension1 = $filename1->getClientOriginalExtension();
            $cut2 = substr($name1, 0,strlen($name1)-(strlen($extension1)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut2);   
            list($width, $height) = getimagesize($filename1); 
            $account->background = Cloudder::show('users/'. $cut2, ['width'=>$width,'height'=>$height]);    
        }
        $account->status = $status;
        $account->role = $role;
        $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();

        if ($account) {
            return response()->json(['success' => 'Cập nhật tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Cập nhật tài khoản thất bại']);
        }

    }


    public function deleteUser(Request $request){
        $id = $request->id;

        $user = DB::table('users')->where('user_id','=',$id)->delete();

        if ($user) {
            return response()->json(['success' => 'Xóa tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Xóa tài khoản thất bại']);
        }
    }


        
    


}
