<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
use App\Shop;
use App\Bill;
use App\Order;
use App\Shipper;
use App\Product;
use App\Comment;
use App\Product_detail;
use Response,File;
use App\User;
use App\Contact;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class AdminController extends Controller
{
    // Order
    public function adminCheck(Request $request){
        $shipper_deliver = $request->shipper_deliver; 
        $shipper_receive = $request->shipper_receive;
        $id = $request->id;

        $check = Order::find($id);
        $check->status = 'Hoàn thành';
        $check->save();
        $ship1 = Shipper::where('shipper_id',$shipper_deliver)->first();
        $order1 = Shipper::where('shipper_id',$shipper_deliver)->update(['order_quantity' => $ship1->order_quantity + 0.5,'salary'=>$ship1->salary + 2000]);

        $ship2 = Shipper::where('shipper_id',$shipper_receive)->first();
        $order2 = Shipper::where('shipper_id',$shipper_receive)->update(['order_quantity' => $ship2->order_quantity + 0.5,'salary'=>$ship2->salary + 2000]);

        if ($ship1->order_quantity == 300) {
            $ship = Shipper::where('shipper_id',$shipper_deliver)->update([
            'status' => 1,
            'salary' => $ship1->salary + 4000000,
            'updated_at' => now()->timezone('Asia/Ho_Chi_Minh'),
            ]);
        }
        if($ship2->order_quantity == 300){
            $ship = Shipper::where('shipper_id',$shipper_receive)->update([
            'status' => 1,
            'salary' => $ship2->salary + 4000000,
            'updated_at' => now()->timezone('Asia/Ho_Chi_Minh'),
            ]);
        }

        $bill = $request->bill;
        $kq =json_decode($bill);

        for ($i=0; $i < count($kq); $i++) { 
            $bill = new Bill;
            $bill->prodetail_id = $kq[$i]->prodetail_id;
            $bill->sale_quantity = $kq[$i]->cart_quantity;
            $bill->shop_id = $kq[$i]->shop_id;
            $bill->status = 1;
            $bill->created_at = now()->timezone('Asia/Ho_Chi_Minh');

            $bill->save();
        }
        if ($bill) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
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

        }else{
            if($role == 'Shipper'){
                $account->avatar ='https://res.cloudinary.com/dtvapimtn/image/upload/v1604656545/users/61662ae2df70212e7861_fpdmex.jpg';
            }else if($role == 'Member'){
                $account->avatar ='https://res.cloudinary.com/dtvapimtn/image/upload/v1604655912/users/cd68867179e387bddef2_m4luzo.jpg';
            }
            else{
                $account->avatar ='https://res.cloudinary.com/dtvapimtn/image/upload/v1604655911/users/207874618bf375ad2ce2_hwnepe.jpg';
            }
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

        $user = User::where('user_id',$id)->update(['status' => 2]);

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


    public function finalOrderAdmin(Request $request){

        $order = Order::where('status','Hoàn thành')->orderBy('created_at','DESC')->paginate(10);
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







    // Thống kê
    public function statistic(){
        $total = DB::table('orders')
                ->join('shops','orders.shop_id','=','shops.shop_id')
                ->selectRaw('orders.shop_id,shops.shop_name,sum(total) as total')
                ->groupBy('orders.shop_id')
                ->paginate(5);
        $money = DB::table('orders')
                ->join('shops','orders.shop_id','=','shops.shop_id')
                ->join('statistic','shops.shop_id','=','statistic.shop_id')
                ->selectRaw('orders.shop_id,shops.shop_name,statistic.sta_total,statistic.month,statistic.year,sum(shipping) as shipping')
                ->whereMonth('orders.created_at', '=', Carbon::now()->subMonth()->month)
                ->groupBy('orders.shop_id')
                ->get();
        $user = User::where('role','=','User')->where('status','=',1)->count();
        $salary_ship = DB::table('shippers')
                ->join('users','users.user_id','=','shippers.user_id')
                ->whereMonth('shippers.created_at', '=', Carbon::now()->subMonth()->month)
                ->orderBy('salary','DESC')->take(5)->get();
        $shop = Shop::where('status',1)->count();
        $shipper = Shipper::count();
        $contact = Contact::where('status',0)->count();
        $pro = DB::table('bills')
            ->join('product_detail','product_detail.prodetail_id','=','bills.prodetail_id')
            ->join('products','products.product_id','=','product_detail.product_id')
            ->join('shops','shops.shop_id','=','bills.shop_id')
            ->orderBy('bills.sale_quantity','DESC')
            ->take(5)
            ->get();
        return response()->json(['user'=>$user,'salary_ship'=>$salary_ship,'total'=>$total,'shop'=>$shop,'shipper'=>$shipper,'contact'=>$contact,'money'=>$money,'product'=>$pro]);

    }
        
    


}
