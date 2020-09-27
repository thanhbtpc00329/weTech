<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
use Response,File;
use App\Banner;

class BannerController extends Controller
{
    // Banner
    public function showBanner(){
        return Banner::all();
    }
	public function addBanner(Request $request){
		$image = $request->file('image');
        $status = $request->status;
        if ($image) {
            //get name image
            $filename =$request->file('image');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'banners/' . $cut);        
        }

        $banner = new Banner;
        $banner->image = Cloudder::show('banners/'. $cut);
        $banner->status = $status;
        $banner->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $banner->save();
        if ($banner) {
            return response()->json(['success' => 'Thêm thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thêm thất bại']);
        }

	}

	public function updateBanner(Request $request)
    {
        $id = $request->id;
        $image = $request->file('image');
        $status = $request->status;

        if ($image) {
            //get name image
            $filename =$request->file('image');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'banners/' . $cut);            
        }

        $banner = Banner::find($id);
        $banner->image = Cloudder::show('banners/'. $cut);
        $banner->status = $status;
        $banner->save();
        $banner->updated_at = now()->timezone('Asia/Ho_Chi_Minh');
        $banner->save();
        if ($banner) {
            return response()->json(['success' => 'Cập nhật thành công!']);  
        }
        else{
            return response()->json(['error' => 'Cập nhật thất bại']);
        }
    }

	public function deleteBanner(Request $request)
    {
    	$id = $request->id;
        $banner = Banner::find($id);
        $banner->delete();
        if ($banner) {
            return response()->json(['success' => 'Xóa thành công!']);  
        }
        else{
            return response()->json(['error' => 'Xóa thất bại']);
        }
    }
}
