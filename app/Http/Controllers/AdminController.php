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
		$data=$request->all();
        if ($request->file('image')) {
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
         $banner->status = $data['status'];
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
        $data=$request->all();
        $banner = Banner::find($data['num']);
        $banner->banner_name=$data['ten'];
        $banner->banner_description=$data['mota'];
        $banner->status=$data['op'];
        // $banner->updated_at = now()->timezone('Asia/Ho_Chi_Minh');
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
    	$data=$request->all();
        $banner = Banner::find($data['num']);
        if ($banner) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
        $banner->delete();
    }
}
