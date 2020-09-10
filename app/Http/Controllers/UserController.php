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
        $name = $request->username;
        $pass = $request->password;
        // $user = DB::table('users')->where('username',$name)->orWhere('email',$name])->get();
        // $pass = DB::table('users')->where('password',$pass)->get();
        $user = User::where('password',$pass)->where('username',$name)->orWhere('email',$name)->where('password',$pass)->get();
        return response()->json(['error' => 'Lỗi',$user]);  
    }
}
