<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\Category;
use App\Bill;
use App\Comment;
use App\Contact;
use App\Order;
use App\Shipper;
use App\Shop;
use App\User;
use App\Wishlist;
class ProductController extends Controller
{
	// Brand
	public function showBrand(){
		return Brand::all();
	}
	public function addBrand(Request $request){
		$data=$request->all();
        $brand = new Brand;
        $brand->brand_name=$data['brand_name'];
        $brand->brand_description=$data['brand_description'];
        $brand->status=$data['status'];
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
        $brand = Brand::find($data['id']);
        $brand->brand_name=$data['brand_name'];
        $brand->brand_description=$data['brand_description'];
        $brand->status=$data['status'];
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
        $brand = Brand::find($data['id']);
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
		$data=$request->all();
        $cate = new Category;
        $cate->cate_name=$data['cate_name'];
        $cate->cate_description=$data['cate_description'];
        $cate->status=$data['status'];
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
        $cate = Category::find($data['id']);
        $cate->cate_name=$data['cate_name'];
        $cate->cate_description=$data['cate_description'];
        $cate->status=$data['status'];
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
        $cate = Category::find($data['id']);
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
    public function showComment()
    {
        return Comment::all();
    }
    public function showContact()
    {
        return Contact::all();
    }
    public function showOrder()
    {
        return Order::all();
    }
    public function showShipper()
    {
        return Shipper::all();
    }
    public function showShop()
    {
        return Shop::all();
    }
    public function showUser()
    {
        return User::all();
    }
    public function showWishlist()
    {
        return Wishlist::all();
    }
}

