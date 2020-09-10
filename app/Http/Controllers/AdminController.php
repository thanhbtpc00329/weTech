<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Cloudder;
use App\Banner;
use Intervention\Image\ImageManagerStatic as Image;

class AdminController extends Controller
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
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
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
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

	public function deleteBanner(Request $request)
    {
    	$id = $request->id;
        $banner = Banner::find($id);
        if ($banner) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
        $banner->delete();
    }
}
