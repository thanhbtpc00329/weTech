<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $gender = $request->gender;
        $address = $request->address;
        $birth_day = $request->birth_day;
        $phone_number = $request->phone_number;

        $account = new User;
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
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }
    public function login(Request $request){
        $name = $request->username;
        $pass = $request->password;
        // $user = DB::table('users')->where('username',$name)->orWhere('email',$name])->get();
        // $pass = DB::table('users')->where('password',$pass)->get();
        $user = User::where('password',$pass)->where('username',$name)->orWhere('email',$name)->where('password',$pass)->get();
        if(count($user) <= 0){
            return response()->json(['error' => 'Sai tên đăng nhập hoặc mật khẩu']);  
        }else{
            return response()->json($user);
        }
    }
}
