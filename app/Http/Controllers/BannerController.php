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
        $banner = Banner::where('type',2)->paginate(10);
        $slide = Banner::where('type',1)->paginate(10);
        return response()->json(['banner'=>$banner,'slide'=>$slide]);
    }

    public function banner(){
        $banner = Banner::where('status',1)->get();
        return response()->json($banner);
    }

	public function addBanner(Request $request){
		$image = $request->file('image');
        if ($image) {
            //get name image
            $filename =$request->file('image');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'banners/' . $cut);  
            list($width, $height) = getimagesize($filename);      
        }

        $banner = new Banner;
        $banner->image = Cloudder::show('banners/'. $cut, ['width'=>$width,'height'=>$height]);
        $banner->status = 0;
        $banner->type = 2;
        $banner->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $banner->save();
        if ($banner) {
            return response()->json(['success' => 'Thêm thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thêm thất bại']);
        }

	}

    public function addSlide(Request $request){
        $image = $request->file('image');
        if ($image) {
            //get name image
            $filename =$request->file('image');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'slideshows/' . $cut);  
            list($width, $height) = getimagesize($filename);      
        }

        $slide = new Banner;
        $slide->image = Cloudder::show('slideshows/'. $cut, ['width'=>$width,'height'=>$height]);
        $slide->status = 0;
        $slide->type = 1;
        $slide->created_at = now()->timezone('Asia/Ho_Chi_Minh');
        $slide->save();
        if ($slide) {
            return response()->json(['success' => 'Thêm thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thêm thất bại']);
        }

    }

	public function unactiveBanner(Request $request)
    {
        $id = $request->id;
        $banner = Banner::find($id);
        $banner->status = 0;
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


    public function activeBanner(Request $request)
    {
        $id = $request->id;
        $banner = Banner::find($id);
        $banner->status = 1;
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
