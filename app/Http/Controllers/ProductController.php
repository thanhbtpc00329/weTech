<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\Category;
class ProductController extends Controller
{
	// Brand
	public function showBrand(){
		return Brand::all();
	}
	public function addBrand(Request $request){
		$data=$request->all();
        $brand = new Brand;
        $brand->brand_name=$data['ten'];
        $brand->brand_description=$data['mota'];
        $brand->status=$data['op'];
        // $brand->created_at = now()->timezone('Asia/Ho_Chi_Minh');
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
        $data=$request->all();
        $brand = Brand::find($data['num']);
        $brand->brand_name=$data['ten'];
        $brand->brand_description=$data['mota'];
        $brand->status=$data['op'];
        // $brand->updated_at = now()->timezone('Asia/Ho_Chi_Minh');
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
    	$data=$request->all();
        $brand = Brand::find($data['num']);
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
		return Cate::all();
	}
    public function addCate(Request $request){
		$data=$request->all();
        $cate = new Category;
        $cate->cate_name=$data['ten'];
        $cate->cate_description=$data['mota'];
        $cate->status=$data['op'];
        // $cate->created_at = now()->timezone('Asia/Ho_Chi_Minh');
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
        $data=$request->all();
        $cate = Category::find($data['num']);
        $cate->cate_name=$data['ten'];
        $cate->cate_description=$data['mota'];
        $cate->status=$data['op'];
        // $cate->updated_at = now()->timezone('Asia/Ho_Chi_Minh');
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
    	$data=$request->all();
        $cate = Category::find($data['num']);
        if ($cate) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
        $cate->delete();
    }



    public function showProduct()
    {
    	return Product::all();
    }
    public function get(Request $req)
    {
    	return $req->all();
    }
}
