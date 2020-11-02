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
        $cate = DB::table('categories')
                ->groupBy('category')
                ->where('status','=',1)
                ->get();
        return response()->json($cate);
    }
    public function cateProduct(Request $request){
        $category = $request->category;

        $cate = Category::where('category',$category)->where('status',1)->get();

        return response()->json($cate);

    }

    public function showCateActive(){
        $cate = Category::where('status','=',1)->paginate(10);

        return response()->json($cate);
    }

    public function showCateUnactive(){
        $cate = Category::where('status','=',0)->paginate(10);

        return response()->json($cate);
    }

    public function showCate(){
        $test = Category::where('status','=',1)->get();
        // foreach ($test as $key) {
        //      $group[$key->category][] = $key;
        //  } 
		return response()->json($test);
	}
    public function addCate(Request $request){
        $cate_name = $request->cate_name;
        $cate_description = $request->cate_description;
        $category = $request->category;
        $status = $request->status;

        $cate = new Category;
        $cate->cate_name=$cate_name;
        $cate->cate_description=$cate_description;
        $cate->image = '';
        $cate->category = $category;
        $cate->status=$status;
        $cate->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $cate->save();
        if ($cate) {
            return response()->json(['success' => 'Thêm danh mục thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thêm thất bại']);
        }
	}

	public function updateCate(Request $request)
    {
        $id = $request->id;
        $cate_name = $request->cate_name;
        $status = $request->status;

        $cate = Category::find($id);
        $cate->cate_name=$cate_name;
        $cate->image = '';
        $cate->status=$status;
        $cate->updated_at = now()->timezone('Asia/Ho_Chi_Minh');
        $cate->save();
        if ($cate) {
            return response()->json(['success' => 'Cập nhật danh mục thành công!']);  
        }
        else{
            return response()->json(['error' => 'Cập nhật thất bại']);
        }
    }

	public function deleteCate(Request $request)
    {
    	$cate_id = $request->cate_id;
        $cate = Category::where('cate_id',$cate_id)->delete();
        if ($cate) {
            return response()->json(['success' => 'Xóa danh mục thành công!']);  
        }
        else{
            return response()->json(['error' => 'Xóa thất bại']);
        }
    }

}
