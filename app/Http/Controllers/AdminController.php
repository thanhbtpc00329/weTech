<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
use App\Shop;
use App\Bill;
use App\Order;
use App\Shipper;
use App\Product;
use App\Product_detail;
use Response,File;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    // Order
    public function adminCheck(Request $request){
        $shipper_id = $request->shipper_id; 
        $id = $request->id;

        $ship = Shipper::where('shipper_id',$shipper_id)->first();
        $check = Order::find($id);
        $check->status = 'Hoàn thành';
        $check->save();
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
        return Bill::paginate(10);
    }

    public function addBill(Request $request){
        $product_id = $request->product_id;
        $sale_amount = $request->sale_amount;
        $shop_id = $request->shop_id;
        $status = $request->status;

        $bill = new Bill;

        $bill->product_id = $product_id;
        $bill->sale_amount = $sale_amount;
        $bill->shop_id = $shop_id;
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

        $account = new User;
        $account->user_id = $id;
        $account->name=$name;
        $account->username=$username;
        $account->email=$email;
        $account->password=$password;
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
        $status = $request->status;
        

        

        $account = User::where('user_id',$user_id)->first();
        $account->name=$name;
        $account->password=$password;
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

        $user = User::where('user_id','=',$id)->delete();

        if ($user) {
            return response()->json(['success' => 'Xóa tài khoản thành công!']);  
        }
        else{
            return response()->json(['error' => 'Xóa tài khoản thất bại']);
        }
    }


    // Order
    public function unactiveOrderAdmin(Request $request){

        $order = Order::where('status','Chờ duyệt')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }

    public function activeOrderAdmin(Request $request){

        $order = Order::where('status','Đã duyệt')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }

    public function updateOrderAdmin(Request $request){

        $order = Order::where('status','Đã đóng gói')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }

    public function insertOrderAdmin(Request $request){
        
        $order = Order::where('status','Đã nhập kho')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }


    public function confirmOrderAdmin(Request $request){
        
        $order = Order::where('status','Đang giao')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }

    public function finishOrderAdmin(Request $request){

        $order = Order::where('status','Đã giao')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }

    public function cancelOrderAdmin(Request $request){

        $order = Order::where('status','Đã hủy')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }

    public function returnOrderAdmin(Request $request){

        $order = Order::where('status','Trả hàng')->orderBy('created_at','DESC')->paginate(10);
        return response()->json($order);
    }


    // Product
    public function unactiveProductAdmin(Request $request){
        $product = DB::table('products')
            ->join('categories','categories.cate_id','=','products.cate_id')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->join('users','users.user_id','=','shops.user_id')
            ->groupby('product_image.prodetail_id')
            ->where('product_detail.status_confirm','=',0)
            ->paginate(10);
            
            return response()->json($product);
    }

    public function activeProductAdmin(Request $request){
        $product = DB::table('products')
            ->join('categories','categories.cate_id','=','products.cate_id')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->join('users','users.user_id','=','shops.user_id')
            ->groupby('product_image.prodetail_id')
            ->where('product_detail.status_confirm','=',1)
            ->paginate(10);
            
            return response()->json($product);
    }

    public function blockProductAdmin(Request $request){
        $prodetail_id = $request->prodetail_id;

        $product = Product_detail::where('prodetail_id',$prodetail_id)->update(['status_confirm'=>0]);
            
        if ($product) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }


    public function confirmProductAdmin(Request $request){
        $prodetail_id = $request->prodetail_id;

        $product = Product_detail::where('prodetail_id',$prodetail_id)->update(['status_confirm'=>1]);
            
        if ($product) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }


    // Search 
    public function searchUnactiveProduct(Request $request)
    {
        $keywords = $request->keywords;

        $product = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('products.product_name','like','%'.$keywords.'%')
            ->where('product_detail.status_confirm','=',0)
            ->groupBy('product_detail.product_id')
            ->paginate(10);
        return response()->json($product);
    }


    public function searchActiveProduct(Request $request)
    {
        $keywords = $request->keywords;

        $product = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('products.product_name','like','%'.$keywords.'%')
            ->where('product_detail.status_confirm','=',1)
            ->groupBy('product_detail.product_id')
            ->paginate(10);
        return response()->json($product);
    }


    public function searchOrderAdmin(Request $request)
    {
        $keywords = $request->keywords;

        $product = Order::where('order_address','like','%'.$keywords.'%')
                ->paginate(10);
        return response()->json($product);
    }    
        
    


}
