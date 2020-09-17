<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Comment;
use App\Contact;
use App\Order;
use App\Wishlist;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $ch1 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ch1len = strlen($ch1);
        $rd = '';
        for ($i = 0; $i < 4; $i++) {
            $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
        }
        $rd = $ran;
        $id = Hash::make($ran);
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




    // Comment
    public function showComment()
    {
        return Comment::all();
    }

    public function addComment(Request $request)
    {
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $content = $request->content;
        $product_id = $request->product_id;
        $rating = $request->rating;
        $status = $request->status;

        $comment = new Comment;
        $comment->name = $name;
        $comment->username = $username;
        $comment->email = $email;
        $comment->content = $content;
        $comment->product_id = $product_id;
        $comment->rating = $rating;
        $comment->status = $status;
        $comment->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $comment->save();
        if ($comment) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function updateComment(Request $request){
        $id = $request->id;  

        $comment = Comment::find($id);
        $comment->status = 1;
        $comment->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $comment->save();
        if ($comment) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    public function deleteComment(Request $request){
        $id = $request->id;  

        $comment = Comment::find($id);

        $comment->delete();
        if ($comment) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    // Contact
    public function showContact()
    {
        return Contact::all();
    }

    public function addContact(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $title = $request->title;
        $content = $request->content;
        $status = $request->status;

        $contact = new Contact;
        $contact->name = $name;
        $contact->email = $email;
        $contact->title = $title;
        $contact->content = $content;
        $contact->status = $status;
        $contact->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $contact->save();
        if ($contact) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function updateContact(Request $request){
        $id = $request->id;  

        $contact = Contact::find($id);
        $contact->status = 1;
        $contact->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $contact->save();
        if ($contact) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    public function deleteContact(Request $request){
        $id = $request->id;  

        $contact = Contact::find($id);

        $contact->delete();
        if ($contact) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }



    // Order
    public function showOrder()
    {
        return Order::all();
    }

    public function addOrder(Request $request){
        $username = $request->username;
        $address = $request->address;
        $shipping = $request->shipping;
        $total = $request->total;
        $status = $request->status;
        $order_detail = $request->order_detail;

        $order = new Order;
        $order->username = $username;
        $order->address = $address;
        $order->shipping = $shipping;
        $order->total = $total;
        $order->status = $status;
        $order->order_detail = $order_detail;
        $order->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    public function updateOrder(Request $request){
        $id = $request->id;
        $status = $request->status;  

        $order = Order::find($id);
        $order->status = $status;
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function deleteOrder(Request $request){
        $id = $request->id;  

        $order = Order::find($id);

        $order->delete();
        if ($order) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    


    public function showWishlist()
    {
        return Wishlist::all();
    }

    public function addWishlist(Request $request){
        $username = $request->username;
        $product_name = $request->product_name;
        $product_image = $request->product_image;
        $product_id = $request->product_id;

        $wishlist = new Wishlist;
        $wishlist->username = $username;
        $wishlist->product_name = $product_name;
        $wishlist->product_image = $product_image;
        $wishlist->product_id = $product_id;
        $wishlist->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $wishlist->save();
        if ($wishlist) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function deleteWishlist(Request $request){
        $id = $request->id;

        $wishlist = Wishlist::find($id);
        $wishlist->delete();
        if ($wishlist) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }


}
