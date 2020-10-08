<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use DB;


class CommentController extends Controller
{
    
    // Comment
    public function showComment()
    {
        return Comment::all();
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

    public function unactiveComment(Request $request){

        $cmt = DB::table('comments')
                ->join('users','users.user_id','=','comments.user_id')
                ->where('comments.status','=',0)
                ->get();
        return response()->json($cmt);
    }


    public function activeComment(Request $request){

        $cmt = DB::table('comments')
                ->join('users','users.user_id','=','comments.user_id')
                ->where('comments.status','=',1)
                ->get();
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
        $comment->status = 0;
        $comment->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $comment->save();
        if ($comment) {
            return response()->json(['success' => 'Thành công!']);  
        }
        else{
            return response()->json(['error' => 'Thất bại']);
        }
    }

    public function activeComment(Request $request){
        $id = $request->id;  

        $comment = Comment::find($id);
        $comment->status = 1;
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
