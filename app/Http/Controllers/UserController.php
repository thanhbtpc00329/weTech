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
    	$data=$request->all();
        $account = new User;
        $account->name=$data['name'];
        $account->username=$data['username'];
        $account->email=$data['email'];
        $account->password=Hash::make($data['password']);
        $account->gender=$data['gender'];
        $account->address=$data['address'];
        $account->birth_day=$data['birth_day'];
        $account->phone_number=$data['phone_number'];
        $account->avatar='dsdfsd';
        $account->status=1;
        $account->role='user';
        // $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();
        if ($account) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }
    public function login(Request $request){
    	$data=$request->all();
        // $user = DB::table('users')->where('username',$data['username'])->orWhere('email',$data['username'])->get();
        // $pass = DB::table('users')->where('password',$data['password'])->get();
        $user = User::where('password',$data['password'])->where('username',$data['username'])->orWhere('email',$data['username'])->where('password',$data['password'])->get();

        if(count($user)>0){
        	return 'Đăng nhập thành công';
        }
        else{
        	return 'Đăng nhập thất bại';
        }

        
        
    }
}
