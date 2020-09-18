<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Product;
use App\Brand;
use App\Category;
use App\Bill;
use App\Product_detail;
use App\Shop;
use App\Product_image;
use DB;


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
    public function showCate(){
		return Category::all();
	}
    public function addCate(Request $request){
        $cate_name = $request->cate_name;
        $cate_description = $request->cate_description;
        $status = $request->status;
        $cate = new Category;
        $cate->cate_name=$cate_name;
        $cate->cate_description=$cate_description;
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
            $da = json_decode($detail);
        return var_dump($da);
    }


    public function addProduct(Request $request){
        $product_name = $request->product_name;
        $brand_id = $request->brand_id;
        $cate_id = $request->cate_id;
        $introduction = $request->introduction;
        $description = $request->description;
        $tag = $request->tag;
        $shop_id = $request->shop_id;

        $prod = new Product;
        $prod->product_name = $product_name;
        $prod->brand_id = $brand_id;
        $prod->cate_id = $cate_id;
        $prod->introduction = $introduction;
        $prod->description = $description;
        $prod->tag = $tag;
        $prod->shop_id = $shop_id;

        $prod->save();


    }

    public function test(Request $request){
        $data = $request->txtContent;
        $test = DB::table('test')->insert(
            ['nd' => $data]
        );  
        if ($test) {
                return 'true';
        }
        else{
            return 'false';
        }    
    }
    
}

