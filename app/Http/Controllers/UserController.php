<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Shipper;
use Illuminate\Support\Facades\Hash;
use DB;
use Response,File;
use Cloudder;

class UserController extends Controller
{
    // Login & Register
    public function register(Request $request)
    {
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
        $account->status=1;
        $account->role='User';
        $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();
        if ($account) {
            return response()->json(['success' => 'Đăng ký tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Đăng ký tài khoản thất bại']);
        }
    }

    public function login(Request $request){
        $name = $request->username;
        $pass = $request->password;
        $user = User::where('password',$pass)->where('username',$name)->orWhere('email',$name)->where('password',$pass)->get();
        if(count($user) <= 0){
            return response()->json(['error' => 'Sai tên đăng nhập hoặc mật khẩu']);  
        }else{
            return response()->json($user);
        }
    }


    public function loginMember(Request $request){
        $name = $request->username;
        $pass = $request->password;
        $user = User::where('password',$pass)->where('username',$name)->orWhere('email',$name)->where('password',$pass)->get();
        if(count($user) <= 0){
            return response()->json(['error' => 'Sai tên đăng nhập hoặc mật khẩu']);  
        }else{
            if ($user[0]->role == 'Member') {
                $mem = DB::table('users')
                ->join('shops','users.user_id','=','shops.user_id')
                ->where('users.username',$name)
                ->orWhere('users.email',$name)
                ->where('users.password',$pass)
                ->where('users.role','Member')
                ->get();
                return response()->json($mem);
            }
            else if($user[0]->role == 'Admin'){
                $mem = User::where('username',$name)
                ->where('users.password',$pass)
                ->orWhere('users.email',$name)
                ->where('users.role','Admin')
                ->get();
                return response()->json($mem);
            }
            else{
                return response()->json(['error' => 'Sai tên đăng nhập hoặc mật khẩu']);
            }
        }
    }


    public function updateAccount(Request $request){
        $user_id = $request->user_id;
        $name = $request->name;
        $password = $request->password;
        $gender = $request->gender;
        $address = $request->address;
        $birth_day = $request->birth_day;
        $phone_number = $request->phone_number;
        
        

        $account = User::where('user_id',$user_id)->first();
        $account->name=$name;
        $account->password=Hash::make($password);
        $account->gender=$gender;
        $account->address=$address;
        $account->birth_day=$birth_day;
        $account->phone_number=$phone_number;
        
        $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();

        if ($account) {
            return response()->json(['success' => 'Cập nhật tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Cập nhật tài khoản thất bại']);
        }

    }


    public function showUnactiveUser(){
        $user = User::where('role','User')->where('status',0)->get();
        return response()->json($user);
    }

    public function showActiveUser(){
        $user = User::where('role','User')->where('status',1)->get();
        return response()->json($user);
    }


    public function activeAccount(Request $request){
        $user_id = $request->user_id;

        $account = User::where('user_id',$user_id)->update(['status' => 1]);

        if ($account) {
            return response()->json(['success' => 'Kích hoạt tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Kích hoạt tài khoản thất bại']);
        }
    }


    public function unactiveAccount(Request $request){
        $user_id = $request->user_id;

        $account = User::where('user_id',$user_id)->update(['status' => 0]);

        if ($account) {
            return response()->json(['success' => 'Vô hiệu hóa tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Vô hiệu hóa tài khoản thất bại']);
        }
    }

}
