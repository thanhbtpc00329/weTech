<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Order;
use DB;


class CommentController extends Controller
{
    
    // Comment
    public function checkComment(Request $request){
        $user_id = $request->user_id;
        $keywords = $request->product_id;

        $cmt = Order::where('user_id',$user_id)->where('order_detail','like','%'.$keywords.'%')->where('status','=','Đã giao')->get();
        if (count($cmt) >= 1 ) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }

    public function showComment()
    {
        return Comment::paginate(10);
    }

    public function detailComment(){
        $cmt = DB::table('comments')
                ->join('users','users.user_id','=','comments.user_id')
                ->join('products','products.product_id','=','comments.product_id')
                ->get();
        return response()->json($cmt);
    }

    public function getComment(Request $request){
        $product_id = $request->product_id;

        $cmt = DB::table('comments')
                ->join('users','users.user_id','=','comments.user_id')
                ->where('comments.product_id','=',$product_id)
                ->where('comments.status','=',1)
                ->get();
        return response()->json($cmt);
    }



    public function getCommentShop(Request $request){
        $id = $request->id;

        $cmt = DB::table('comment_detail')
                ->join('shops','shops.shop_id','=','comment_detail.shop_id')
                ->where('comment_detail.cmt_id','=',$id)
                ->where('comment_detail.status','=',1)
                ->get();
        return response()->json($cmt);
    }


    public function countComment(Request $request){
        $product_id = $request->product_id;

        $cmt = DB::table('comments')
                ->where('comments.product_id','=',$product_id)
                ->where('comments.status','=',1)
                ->count();
        return $cmt;
    }



    public function unactiveCommentAdmin(Request $request){

        $cmt = DB::table('comments')
                ->join('users','users.user_id','=','comments.user_id')
                ->where('comments.status','=',0)
                ->paginate(10);
        return response()->json($cmt);
    }


    public function activeCommentAdmin(Request $request){

        $cmt = DB::table('comments')
                ->join('users','users.user_id','=','comments.user_id')
                ->where('comments.status','=',1)
                ->paginate(10);
        return response()->json($cmt);
    }


    public function addComment(Request $request)
    {
        $user_id = $request->user_id;
        $content = $request->content;
        $product_id = $request->product_id;
        $rating = $request->rating;
        
        
        $comment = new Comment;
        $comment->user_id = $user_id;
        $comment->content = $content;
        $comment->product_id = $product_id;
        $comment->rating = $rating;
        $comment->status = 1;
        $comment->is_reply = 0;
        $comment->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $comment->save();
        if ($comment) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }

    public function unActiveComment(Request $request){
        $id = $request->id;  

        $comment = Comment::find($id);
        $comment->status = 0;
        $comment->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $comment->save();
        if ($comment) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }

    }

    public function deleteComment(Request $request){
        $id = $request->id;  

        $comment = Comment::find($id);

        $comment->delete();
        if ($comment) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }

    }
}
