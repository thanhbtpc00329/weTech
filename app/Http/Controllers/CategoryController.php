<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Response,File;
use Cloudder;
use DB;

class CategoryController extends Controller
{
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

        $cate = Category::find($id);
        $cate->cate_name=$cate_name;
        $cate->cate_description=$cate_description;
        $cate->image = Cloudder::show('categories/'. $cut);
        $cate->category = $category;
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



}
