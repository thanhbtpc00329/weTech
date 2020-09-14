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
        $product = DB::table('products')->leftJoin('product_detail','products.product_id','=','product_detail.product_id')->groupBy('product_detail.product_id')->get();
        return response()->json($product);
    }

    public function test(){
        return view('upload');
    }
    
}

