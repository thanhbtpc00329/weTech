<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Product;
use App\Brand;
use App\Category;
use App\Bill;
use App\Product_detail;
use App\Shop;
use App\Product_image;
use DB;
use Cloudder;


class ProductController extends Controller
{
	// Brand
	public function showBrand(){
		return Brand::all();
	}
	public function addBrand(Request $request){
		$brand_name = $request->brand_name;
        $brand_description = $request->brand_description;
        $status = $request->status;
        $brand = new Brand;
        $brand->brand_name=$brand_name;
        $brand->brand_description=$brand_description;
        $brand->status=$status;
        $brand->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $brand->save();
        if ($brand) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
	}

	public function updateBrand(Request $request)
    {
        $id = $request->id;
        $brand_name = $request->brand_name;
        $brand_description = $request->brand_description;
        $status = $request->status;
        $brand = Brand::find($id);
        $brand->brand_name=$brand_name;
        $brand->brand_description=$brand_description;
        $brand->status=$status;
        $brand->updated_at = now()->timezone('Asia/Ho_Chi_Minh');
        $brand->save();
        if ($brand) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

	public function deleteBrand(Request $request)
    {
    	$id = $request->id;
        $brand = Brand::find($id);
        if ($brand) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
        $brand->delete();
    }





    //Category
    public function category(){
        $cate = DB::table('categories')->groupBy('category')->get();
        return response()->json($cate);
    }
    public function cateProduct(Request $request){
        $category = $request->category;

        $cate = Category::where('category',$category)->get();

        return response()->json($cate);

    }
    public function showCate(){
		return Category::all();
	}
    public function addCate(Request $request){
        $cate_name = $request->cate_name;
        $cate_description = $request->cate_description;
        $image = $request->file('image');
        if ($image) {
            //get name image
            $filename = $request->file('image');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'categories/' . $cut);            
        }
        $category = $request->category;
        $status = $request->status;

        $cate = new Category;
        $cate->cate_name=$cate_name;
        $cate->cate_description=$cate_description;
        $cate->image = Cloudder::show('categories/'. $cut);
        $cate->category = $category;
        $cate->status=$status;
        $cate->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $cate->save();
        if ($cate) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
	}

	public function updateCate(Request $request)
    {
        $id = $request->id;
        $cate_name = $request->cate_name;
        $cate_description = $request->cate_description;
        $status = $request->status;
        $cate = Category::find($id);
        $cate->cate_name=$cate_name;
        $cate->cate_description=$cate_description;
        $cate->status=$status;
        $cate->updated_at = now()->timezone('Asia/Ho_Chi_Minh');
        $cate->save();
        if ($cate) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

	public function deleteCate(Request $request)
    {
    	$id = $request->id;
        $cate = Category::find($id);
        if ($cate) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
        $cate->delete();
    }




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


    public function productShop(Request $request){
        $shop_id = $request->shop_id;

        $product = DB::table('products')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->where('products.shop_id',$shop_id)
            ->groupBy('product_detail.product_id')
            ->select('products.product_id','products.product_name','products.introduction','products.description','products.status','product_detail.price','product_detail.quantity','product_detail.discount_price','product_image.image','shops.shop_name')
            ->get();
        return response()->json($product);
    }


    public function showDetail(Request $request){
        $id = $request->id;

        $detail = DB::table('products')
            ->join('brands','brands.brand_id','=','products.brand_id')
            ->join('categories','categories.cate_id','=','products.cate_id')
            ->join('product_detail','product_detail.product_id','=','products.product_id')
            ->join('product_image','product_image.prodetail_id','=','product_detail.prodetail_id')
            ->join('shops','shops.shop_id','=','products.shop_id')
            ->join('users','users.user_id','=','shops.user_id')
            ->where('products.product_id','=',$id)
            ->select('products.product_id','products.product_name','products.introduction','products.description','products.tag','brands.brand_name','categories.cate_name','categories.category','product_detail.prodetail_id','product_detail.price','product_detail.color','product_detail.quantity','product_detail.size','product_detail.discount_price','product_detail.status','product_image.image','shops.shop_name','shops.address','shops.phone_number','product_detail.origin','product_detail.accessory','product_detail.dimension','product_detail.weight','product_detail.system','product_detail.material','product_detail.screen_size','product_detail.wattage','product_detail.resolution','product_detail.memory','users.avatar')
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

    
    public function addProductDetail(Request $request){
        $ch1 = '01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $ch1len = strlen($ch1);
            $rd = '';
            for ($i = 0; $i < 4; $i++) {
                $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
            }
        $id = $rd;
        $product_name = $request->product_name;
        $brand_id = $request->brand_id;
        $cate_id = $request->cate_id;
        $introduction = $request->introduction;
        $description = $request->description;
        $tag = $request->tag;
        $shop_id = $request->shop_id;

        $prod = new Product;
        $prod->product_id = $id;
        $prod->product_name = $product_name;
        $prod->brand_id = $brand_id;
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

        if($pro){
            return 'Thành công';
        }
        else{
            return 'Thất bại';
        }

    }
    

    public function test(Request $request){
        
        // $data = $request->txtContent;
        // $test = DB::table('test')->insert(
        //     ['nd' => $data]
        // );  
        // if ($test) {
        //         return 'true';
        // }
        // else{
        //     return 'false';
        // }    
    }
    
}

