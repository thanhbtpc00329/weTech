<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Shop;
use App\Order;
use App\Product_detail;
use App\Notification;
use App\Comment;
use App\Comment_detail;
use DB; 
use Carbon\Carbon;
use App\Statistic;
use App\Bill;


class ShopController extends Controller
{
    // Shop
    public function accountShopActive()
    {
        $shop = User::where('role','Member')->where('status',1)->paginate(10);
        return response()->json($shop);
    }

    public function accountShopUnactive()
    {
        $shop = User::where('role','Member')->where('status',0)->paginate(10);
        return response()->json($shop);
    }

    public function showShop(){
    	$shop = DB::table('shops')
    			->join('users','users.user_id','=','shops.user_id')
    			->paginate(10);
    	return response()->json($shop);
    }

    public function getShop(){
        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->where('shops.status','=',1)
                ->paginate(10);
        return response()->json($shop);
    }  

    public function unactiveShop(){
        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->where('shops.status','=',0)
                ->where('users.status','=',1)
                ->paginate(10);
        return response()->json($shop);
    }    

    public function blockShop(){
        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->where('shops.status','=',2)
                ->where('users.status','=',0)
                ->paginate(10);
        return response()->json($shop);
    } 

    public function detailShop(Request $request){
        $shop_id = $request->id;

        $shop = DB::table('shops')
                ->join('users','users.user_id','=','shops.user_id')
                ->select('shops.shop_id','shops.shop_name','shops.shop_address','shops.phone_number','shops.background','shops.shop_range','shops.location','shops.tax','users.avatar')
                ->where('shop_id','=',$shop_id)
                ->get();
        return response()->json($shop);
    }


    public function rangeShop(Request $request){
        $shop_id = $request->shop_id;

        $shop = Shop::where('shop_id','=',$shop_id)->first();
        return response()->json($shop);
    }



    public function addShop(Request $request){
        $shop_name = $request->shop_name;
        $user_id = $request->user_id;
        $identity_card = $request->identity_card;
        $shop_address = $request->shop_address;
        $location = $request->location;
        $shop_range = $request->shop_range;
        $phone_number = $request->phone_number;
        $tax = $request->tax;

        $img = User::where('user_id',$user_id)->where('social',null)->first();
        if($img){
            $img->avatar ='https://res.cloudinary.com/dtvapimtn/image/upload/v1604655912/users/cd68867179e387bddef2_m4luzo.jpg';
            $img->save();


            $shop = new Shop;
            $shop->shop_name = $shop_name;
            $shop->user_id = $user_id;
            $shop->identity_card = $identity_card;
            $shop->shop_address = $shop_address;
            $shop->location = $location;
            $shop->shop_range = $shop_range;
            $shop->phone_number = $phone_number;
            $shop->tax = $tax;
            $shop->background = 'https://res.cloudinary.com/dtvapimtn/image/upload/v1604657857/backgrounds/background_skzncs.jpg';
            $shop->status = '0';
            $shop->created_at = now()->timezone('Asia/Ho_Chi_Minh');

            $shop->save();
        }
        
        if (isset($shop)) {
            return response()->json(['success' => 'Đăng ký thành viên thành công!']);  
        }
        else{
            return response()->json(['error' => 'Đăng ký thành viên thất bại']);
        }  
    }

    public function activeShop(Request $request){
        $shop_id = $request->shop_id;
        $user_id = $request->user_id;

        $shop = Shop::where('shop_id',$shop_id)->update(['status' => 1]);
        $mem = User::where('user_id',$user_id)->update(['role' => 'Member']);
        $pro = DB::table('products')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->where('products.shop_id','=',$shop_id)
                ->update(['product_detail.status_confirm'=>1]);
        if ($pro) {
            return response()->json(['success' => 'Kích hoạt thành viên thành công!']);  
        }
        else{
            return response()->json(['error' => 'Kích hoạt thành viên thất bại']);
        }
    }


    public function cancelShop(Request $request){
        $shop_id = $request->shop_id;
        $user_id = $request->user_id;
        $shop = Shop::where('shop_id',$shop_id)->update(['status' => 2]);
        $mem = User::where('user_id',$user_id)->update(['status' => 0]);
        $pro = DB::table('products')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->where('products.shop_id','=',$shop_id)
                ->update(['product_detail.status_confirm'=>2]);
        if ($pro) {
            return response()->json(['success' => 'Chặn thành viên thành công!']);  
        }
        else{
            return response()->json(['error' => 'Chặn thành viên thất bại']);
        }
    }


    public function updateShop(Request $request){
        $id = $request->shop_id;
        $name = $request->name;
        $shop_address = $request->shop_address;
        $location = $request->location;
        $shop_range = $request->shop_range;
        $phone_number = $request->phone_number;
        $status = $request->status;
        $tax = $request->tax;

        $shop = Shop::where('shop_id',$id)->update([
            'name'=>$name,
            'address'=>$address,
            'location'=>$location,
            'shop_range'=>$shop_range,
            'phone_number'=>$phone_number,
            'tax' => $tax,
            'status'=>$status,
            'updated_at'=>now()->timezone('Asia/Ho_Chi_Minh')
        ]);

        if ($shop) {
            return response()->json(['success' => 'Cập nhật thành công!']);  
        }
        else{
            return response()->json(['error' => 'Cập nhật thất bại']);
        }  
    }

    public function deleteShop(Request $request){
        $id = $request->shop_id;

        $shop = Shop::where('shop_id',$id)->delete();
        if ($shop) {
            return response()->json(['success' => 'Xóa thành công!']);  
        }
        else{
            return response()->json(['error' => 'Xóa thất bại']);
        }  
    }

    // Order
    public function updateOrder(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã đóng gói';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }


    // Order

    public function getOrderShop(Request $request){
        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function unactiveOrderShop(Request $request){
        $now = Carbon::now()->format('Y-m-d');
        $ldom = Carbon::now()->endOfMonth()->toDateString();
        $shop_id = $request->shop_id;
        $check = Statistic::where('shop_id',$shop_id)->where('updated_at',$now)->first();
        if(($now == $ldom) && empty($check)){
            $m = Carbon::now()->month;
            $y = Carbon::now()->year;

            $total = DB::table('orders')
                ->join('shops','orders.shop_id','=','shops.shop_id')
                ->selectRaw('orders.shop_id,sum(total) as total')
                ->groupBy('orders.shop_id')
                ->where('orders.shop_id','=',$shop_id)
                ->whereMonth('orders.created_at', '=', Carbon::now()->month)
                ->get();
            $h = now()->timezone('Asia/Ho_Chi_Minh')->format('H:i:s');
            $time = $y.'-'.$m.'-01 '.$h;
            $add = new Statistic;
            $add->month = $m;
            $add->year = $y;
            $add->sta_total = $total[0]->total;
            $add->shop_id = $total[0]->shop_id;
            $add->created_at = $time;
            $add->updated_at = $now;
            $add->save();
        }
        
        

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Chờ duyệt')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function activeOrderShop(Request $request){
        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Đã duyệt')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function updateOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Đã đóng gói')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }


    public function toWarehouse(Request $request){
        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where(function($query) {
                    $query->orWhere('orders.status','=','Đang lấy hàng')
                          ->orWhere('orders.status','=','Đã lấy hàng')
                          ->orWhere('orders.status','=','Đã lấy hàng')
                          ->orWhere('orders.status','=','Đã nhập kho');
                })
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order); 

    }


    public function confirmOrderShop(Request $request){
        
        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Đang giao')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function finishOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Đã giao')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function cancelOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Đã hủy')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function returnOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Trả hàng')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function insertOrderShop(Request $request){

        $shop_id = $request->shop_id;

        $order = DB::table('orders')
                ->join('users','users.user_id','=','orders.user_id')
                ->where('orders.shop_id','=',$shop_id)
                ->where('orders.status','=','Đã nhập kho')
                ->orderBy('orders.created_at','DESC')
                ->select('orders.id','orders.user_id','orders.order_address','orders.shipping','orders.total','orders.shop_id','orders.shipper_deliver','orders.shipper_receive','orders.status','orders.order_detail','orders.created_at','users.name','users.avatar','users.phone_number')
                ->paginate(5);
        return response()->json($order);
    }

    public function shopCheck(Request $request){
        $id = $request->id; 
        $total = $request->total;

        $order = Order::find($id);
        $order->status = 'Đã duyệt';
        $order->total = $total;
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }

    public function shopUpdate(Request $request){
        $id = $request->id; 

        $order = Order::find($id);
        $order->status = 'Đã đóng gói';
        $order->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $order->save();
        if ($order) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Lỗi']);
        }
    }

    public function activeDiscount(Request $request)
    {
        $shop_id = $request->shop_id;

        $pro = DB::table('product_detail')
            ->join('products','products.product_id','=','product_detail.product_id')
            ->where('products.shop_id','=',$shop_id)
            ->select('product_detail.prodetail_id','product_detail.created_at','product_detail.updated_at')
            ->get();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = time();
        
        for ($i=0; $i < count($pro); $i++) { 
            // To time
            $ttime_stamp = strtotime($pro[$i]->updated_at);
            if($now >= $ttime_stamp){
                $prod = Product_detail::where('prodetail_id',$pro[$i]->prodetail_id)->update(['status_discount' => 0]);
            }
        }
        $prod2 = DB::table('products')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
                ->groupBy('product_image.prodetail_id')
                ->where('products.shop_id','=',$shop_id)
                ->where('product_detail.status_discount','=',1)
                ->where('product_detail.status_confirm','=',1)
                ->select('product_detail.prodetail_id','products.product_id','products.product_name','products.brand','products.cate_id','product_detail.price','product_image.image','product_detail.percent','product_detail.discount_price')
                ->paginate(5);
        return response()->json($prod2);
    }

    public function unactiveDiscount(Request $request)
    {
        $shop_id = $request->shop_id;

        $pro = DB::table('product_detail')
            ->join('products','products.product_id','=','product_detail.product_id')
            ->where('products.shop_id','=',$shop_id)
            ->select('product_detail.prodetail_id','product_detail.created_at','product_detail.updated_at')
            ->get();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = time();
        
        for ($i=0; $i < count($pro); $i++) { 
            // To time
            $ttime_stamp = strtotime($pro[$i]->updated_at);
            if($now >= $ttime_stamp){
                $prod = Product_detail::where('prodetail_id',$pro[$i]->prodetail_id)->update(['status_discount' => 0]);
            }
        }
        $prod2 = DB::table('products')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
                ->groupBy('product_detail.product_id')
                ->where('products.shop_id','=',$shop_id)
                ->where('product_detail.status_discount','=',0)
                ->where('product_detail.status_confirm','=',1)
                ->select('products.product_id','products.product_name','products.brand','products.cate_id','product_detail.price','product_image.image')
                ->get();
        return response()->json($prod2);
    }



    public function discount(Request $request)
    {
        $from_day = $request->from_day;
        $to_day = $request->to_day;
        $percent = $request->percent;
        $prodetail_id = $request->prodetail_id;
        $pp = ltrim($prodetail_id,"'");
        $kk = rtrim($pp,"'");
        $id = json_decode($kk);

            for ($i=0; $i < count($id); $i++) { 
                $pro = Product_detail::where('prodetail_id',$id[$i])->first();
                $price = $pro->price;
                $pro->percent = $percent;
                $pro->discount_price = $price - ($price * ($percent / 100));
                $pro->status_discount = 1;
                $pro->created_at = str_replace('T',' ',$from_day);
                $pro->updated_at = str_replace('T',' ',$to_day);
                $pro->save();
            }

        if ($pro) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }


    // Count sp theo shop
    public function countProductShop(Request $request){
        $shop_id = $request->shop_id;

        $product = DB::table('product_detail')
            ->join('products','product_detail.product_id','=','products.product_id')
            ->where('products.shop_id','=',$shop_id)
            ->where('product_detail.status_confirm','=',1)
            ->count();
        return $product;
    }


    public function searchProductShop(Request $request)
    {
        $keywords = $request->keywords;
        $shop_id = $request->shop_id;

        $product = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('products.product_name','like','%'.$keywords.'%')
            ->where('product_detail.status_confirm','=',1)
            ->where('products.shop_id','=',$shop_id)
            ->groupBy('product_detail.product_id')
            ->paginate(5);
        return response()->json($product);
    }


    public function searchOrderShop(Request $request)
    {
        $keywords = $request->keywords;
        $shop_id = $request->shop_id;

        $product = Order::where('order_address','like','%'.$keywords.'%')->where('shop_id',$shop_id)->paginate(5);
        return response()->json($product);
    } 


    public function searchUnactiveOrderShop(Request $request)
    {
        $keywords = $request->keywords;
        $shop_id = $request->shop_id;

        $product = Order::where('order_address','like','%'.$keywords.'%')->where('shop_id',$shop_id)->where('status','Chờ duyệt')->paginate(5);
        return response()->json($product);
    } 







    // Notification
    public function addNotification(Request $request){
        $order_id = $request->order_id;
        $message = $request->message;
        $type = $request->type;

        $tb = new Notification;
        $tb->order_id = $order_id;
        $tb->message = $message;
        $tb->type = $type;
        $tb->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $tb->save();
        
        if ($tb) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }

    public function deleteNotification(Request $request){
        $id = $request->id;

        $tb = Notification::find($id);
        $tb->delete();
        
        if ($tb) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }


    public function notification(Request $request){
        $tb = Notification::all();

        return response()->json($tb);
    }




    // Comment
    public function commentShop(Request $request){
        $shop_id = $request->shop_id;

        $cmt = DB::table('comments')
                ->join('products','products.product_id','=','comments.product_id')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
                ->join('shops','shops.shop_id','=','products.shop_id')
                ->join('users','users.user_id','=','comments.user_id')
                ->groupby('product_detail.product_id')
                ->where('products.shop_id','=',$shop_id)
                ->where('comments.status','=',1)
                ->select('comments.id','comments.product_id','comments.content','comments.rating','comments.is_reply','products.product_name','product_image.image','users.name','users.phone_number','comments.created_at','shops.shop_id','users.avatar')
                ->paginate(5);

        return response()->json($cmt);
    }

    public function unactiveCommentShop(Request $request){
        
        $shop_id = $request->shop_id;

        $cmt = DB::table('comments')
                ->join('products','products.product_id','=','comments.product_id')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
                ->join('users','users.user_id','=','comments.user_id')
                ->where('products.shop_id','=',$shop_id)
                ->where('comments.status','=',1)
                ->where('comments.is_reply','=',0)
                ->groupBy('product_detail.product_id')
                ->select('comments.id','comments.product_id','comments.content','comments.rating','comments.is_reply','products.product_name','product_image.image','users.name','users.phone_number','comments.created_at','shops.shop_id','users.avatar')
                ->paginate(5);

        return response()->json($cmt);
    }


    public function activeCommentShop(Request $request){
        $shop_id = $request->shop_id;

        $cmt = DB::table('comments')
                ->join('products','products.product_id','=','comments.product_id')
                ->join('shops','shops.shop_id','=','products.shop_id')
                ->join('product_detail','product_detail.product_id','=','products.product_id')
                ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
                ->join('users','users.user_id','=','comments.user_id')
                ->join('comment_detail','comment_detail.cmt_id','=','comments.id')
                ->where('products.shop_id','=',$shop_id)
                ->where('comments.status','=',1)
                ->where('comments.is_reply','=',1)
                ->groupBy('product_detail.product_id')
                ->select('comments.id','comments.product_id','comments.content','comments.rating','comments.is_reply','products.product_name','product_image.image','users.name','users.phone_number','comments.created_at','shops.shop_id','users.avatar')
                ->paginate(5);

        return response()->json($cmt);
    }

    public function replyComment(Request $request){
        $id = $request->id;
        $shop_id = $request->shop_id;
        $product_id = $request->product_id;
        $content = $request->content;


        $cmt = new Comment_detail;
        $cmt->cmt_id = $id;
        $cmt->shop_id = $shop_id;
        $cmt->content = $content;
        $cmt->product_id = $product_id;
        $cmt->status = 1;
        $cmt->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $cmt->save();

        $com = Comment::where('id',$id)->update(['is_reply'=>1]);

        if ($com) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }


    // Thống kê

    public function statisticShop (Request $request){
        $shop_id = $request->shop_id;

        $total = Statistic::where('shop_id',$shop_id)->get();
        $pro = DB::table('products')
                ->join('product_detail','products.product_id','=','product_detail.product_id')
                ->where('products.shop_id','=',$shop_id)
                ->count();
        $sale = Bill::where('shop_id',$shop_id)->sum('sale_quantity');
        $cmt = DB::table('comments')
                ->join('comment_detail','comments.id','=','comment_detail.cmt_id')
                ->where('comment_detail.shop_id','=',$shop_id)
                ->count();
        return response()->json(['total'=>$total,'product'=>$pro,'sale'=>$sale,'comment'=>$cmt]);
    }


}
