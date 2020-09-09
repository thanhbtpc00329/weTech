<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
use App\Banner;
use Intervention\Image\ImageManagerStatic as Image;

class AdminController extends Controller
{
    // Banner
    public function showBanner(){
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        echo Image::make($request->get('image'))->save(public_path('images/').$name);
    }
	public function addBanner(Request $request){
		$data=$request->all();
       //  if($request->get('image'))
       // {
       //    $image = $request->get('image');
       //    $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
       //    \Image::make($request->get('image'))->save(public_path('images/').$name);
       //  }
        return $request->get('image');

       // $image= new FileUpload();
       // $image->image_name = $name;
       // $image->save();

       // return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        // echo $data['hinh'];
        // // if ($request->hasFile('avatar')) {
        // //     //get name image
        //     $filename = $data['hinh'];
        //     $name = $filename->getClientOriginalName();
        //     //upload image
        //     Cloudder::upload($name, 'products/' . $name);
        //  // }
        //  //get url image on Cloudinary
        //  // return Cloudder::show('uploads/'. $name);
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
