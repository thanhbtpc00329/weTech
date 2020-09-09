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
        $account->password=Hash::make($data['pass']);
        $account->gender=$data['gender'];
        $account->address=$data['dc'];
        $account->birth_day=$data['date'];
        $account->phone_number=$data['phone'];
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
        $user = DB::table('users')->where('username',$data['username'])->orWhere('email',$data['username'])->get();
        $pass = DB::table('users')->where('password',$data['pass'])->get();
        if(count($user)>0 && count($pass)>0){
        	echo 'Đăng nhập thành công';
        }
        else{
        	echo 'Đăng nhập thất bại';
        }

        
        
    }
}
