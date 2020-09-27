<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Product;
use App\Category;
use App\Bill;
use App\Product_detail;
use App\Shop;
use App\Product_image;
use App\Banner;
use DB;
use Cloudder;
use Response,File;


class ProductController extends Controller
{
    // Product
    public function showProduct()
    {
        $product = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->groupBy('product_detail.product_id')
            ->select('products.product_id','products.product_name','products.introduction','products.description','products.status','product_detail.price','product_detail.quantity','product_detail.discount_price','product_image.image','shops.shop_name')
            ->get();
        return response()->json($product);
    }

    public function productType(Request $request){
        $cate_id = $request->cate_id;

        $product = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('products.cate_id',$cate_id)
            ->groupBy('product_detail.product_id')
            ->select('products.product_id','products.product_name','products.introduction','products.description','products.status','product_detail.price','product_detail.quantity','product_detail.discount_price','product_image.image','shops.shop_name')
            ->get();
        return response()->json($product);
    }

    public function showProductShop(Request $request){
        $shop_id = $request->shop_id;

        $product = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('products.shop_id','=',$shop_id)
            ->groupby('product_detail.product_id')
            ->select('products.product_id','products.product_name','products.introduction','products.description','products.status','product_detail.price','product_detail.quantity','product_detail.discount_price','product_image.image','shops.shop_name','products.brand','product_detail.prodetail_id','product_detail.color','product_detail.size','product_detail.status','shops.shop_id','shops.shop_name','shops.phone_number','product_detail.origin','product_detail.accessory','product_detail.dimension','product_detail.weight','product_detail.system','product_detail.material','product_detail.screen_size','product_detail.wattage','product_detail.resolution','product_detail.memory')
            ->get();
        return response()->json($product);
    }


    public function productShop(Request $request){
        $shop_id = $request->shop_id;

        $product = DB::table('product_detail')
            ->join('products','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('products.shop_id','=',$shop_id)
            ->groupby('product_image.prodetail_id')
            ->select('products.product_id','products.product_name','products.introduction','products.description','products.status','product_detail.price','product_detail.quantity','product_detail.discount_price','product_image.image','shops.shop_name','products.brand','product_detail.prodetail_id','product_detail.color','product_detail.size','product_detail.status','shops.shop_id','shops.shop_name','shops.phone_number','product_detail.origin','product_detail.accessory','product_detail.dimension','product_detail.weight','product_detail.system','product_detail.material','product_detail.screen_size','product_detail.wattage','product_detail.resolution','product_detail.memory')
            ->get();
        return response()->json($product);
    }


    public function showDetail(Request $request){
        $id = $request->id;

        $detail = DB::table('products')
            ->join('categories','categories.cate_id','=','products.cate_id')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->join('users','users.user_id','=','shops.user_id')
            ->where('products.product_id','=',$id)
            ->select('products.product_id','products.product_name','products.introduction','products.description','products.tag','products.brand','categories.cate_name','categories.category','product_detail.prodetail_id','product_detail.price','product_detail.color','product_detail.quantity','product_detail.size','product_detail.discount_price','product_detail.status','product_image.image','shops.shop_id','shops.shop_name','shops.address','shops.phone_number','product_detail.origin','product_detail.accessory','product_detail.dimension','product_detail.weight','product_detail.system','product_detail.material','product_detail.screen_size','product_detail.wattage','product_detail.resolution','product_detail.memory','users.avatar')
            ->get();
            
            return response()->json($detail);
    }


    public function detailInfo(Request $request){
        $id = $request->id;

        $detail = DB::table('product_detail')
            ->where('product_id',$id)
            
            ->get();
            $da = json_decode($detail);
            
            $arr = Schema::getColumnListing('product_detail');
            $da4 = [];
            for ($j=0; $j < count($da) ; $j++) { 
                $da2 = $da[$j];
                for ($i= 2; $i <= 19 ; $i++) {
                    $x = $arr[$i];
                    unset($da2->product_id);
                    if ($arr[$i] != $arr[6]) { 
                        if($da2->$x == null){
                            unset($da2->$x);
                        }
                    }
                    else{unset($da2->status);}
                }
                array_push($da4,$da2);
            }
            $da3 = $da4;
            
            return response()->json($da3);
    }

    public function detailImage(Request $request){
        $prodetail_id = $request->id;

        $prod = DB::table('product_detail')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('products','products.product_id','=','product_detail.product_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('product_detail.prodetail_id','=',$prodetail_id)
            ->first();
        return response()->json($prod);
    }

    public function uploadProductImage(Request $request){
        $image = $request->file('image');
        if ($image) {
            //get name image
            $filename =$request->file('image');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'products/' . $cut);        
        }

        return Cloudder::show('products/'. $cut);
    }

    
    public function addProductDetail(Request $request){
        $ch1 = '01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $ch1len = strlen($ch1);
            $rd = '';
            for ($i = 0; $i < 4; $i++) {
                $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
            }
        $id = $rd;
        $product_name = $request->product_name;
        $brand = $request->brand;
        $cate_id = $request->cate_id;
        $introduction = $request->introduction;
        $description = $request->description;
        $tag = $request->tag;
        $shop_id = $request->shop_id;

        $prod = new Product;
        $prod->product_id = $id;
        $prod->product_name = $product_name;
        $prod->brand = $brand;
        $prod->cate_id = $cate_id;
        $prod->introduction = $introduction;
        $prod->description = $description;
        $prod->tag = $tag;
        $prod->shop_id = $shop_id;
        $prod->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $prod->save();
        
        
        $product_id = $id;
        $price = $request->price;
        $color = $request->color;
        $quantity = $request->quantity;
        $size = $request->size;
        $status = $request->status;
        $discount_price = $request->discount_price;
        $origin = $request->origin;
        $accessory = $request->accessory;
        $dimension = $request->dimension;
        $weight = $request->weight;
        $system = $request->system;
        $material = $request->material;
        $screen_size = $request->screen_size;
        $wattage = $request->wattage;
        $resolution = $request->resolution;
        $memory = $request->memory;

                

        $pro = new Product_detail;
        $pro->product_id = $product_id;
        $pro->price = $price;
        $pro->color = $color;
        $pro->quantity = $quantity;
        $pro->size = $size;
        $pro->status = $status;
        $pro->discount_price = $discount_price;
        $pro->origin = $origin;
        $pro->accessory = $accessory;
        $pro->dimension = $dimension;
        $pro->weight = $weight;
        $pro->system = $system;
        $pro->material = $material;
        $pro->screen_size = $screen_size;
        $pro->wattage = $wattage;
        $pro->resolution = $resolution;
        $pro->memory = $memory;
        $pro->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $pro->save();

        if ($pro) {
            return response()->json(['success' => 'Thêm sản phẩm thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thêm thất bại']);
        }

    }


    public function addProductImage(Request $request){
        $prodetail_id = $request->prodetail_id;
        
    }
    

    public function test(Request $request){
        // $name = $request->username;

        // $test = DB::table('orders')
        //     ->select('username','created_at',DB::raw('COUNT(1) as x'))
        //     ->where('username','=','nva')
        //     ->groupby('username','created_at')
        //     ->get();

        // $ds = DB::table('orders')
        //     ->where('username','=',$test[0]->username)
        //     ->where('created_at','=',$test[0]->created_at)
        //     ->get();
        
        // return response()->json($ds);

        // $arr = $request->cart;
        // $arr1 = json_decode($arr);    

        // foreach ($arr1 as $key) {
        //     $group[$key->shop_id][]= $key;

        // }
        // return response()->json($group);
        $time = now()->timezone('Asia/Ho_Chi_Minh');
        $arr = [3,4,5,6,7,8,3,4,6,7,8,9,9];
        for ($i=0; $i < count($arr); $i++) { 
            
            $image = $arr[$i];
            $ban = new Banner;
            $ban->image = $image;
            $ban->status = 1;
            $ban->created_at = $day;

            $ban->save();
        }
        
        




         
    }
    
}

