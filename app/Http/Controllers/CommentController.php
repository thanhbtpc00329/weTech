<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    
    // Comment
    public function showComment()
    {
        return Comment::all();
    }

    public function addComment(Request $request)
    {
        $user_id = $request->user_id;
        $content = $request->content;
        $product_id = $request->product_id;
        $rating = $request->rating;
        $status = $request->status;

        $comment = new Comment;
        $comment->user_id = $user_id;
        $comment->content = $content;
        $comment->product_id = $product_id;
        $comment->rating = $rating;
        $comment->status = $status;
        $comment->created_at = now()->timezone('Asia/Ho_Chi_Minh');

        $comment->save();
        if ($comment) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function activeComment(Request $request){
        $id = $request->id;  

        $comment = Comment::find($id);
        $comment->status = 1;
        $comment->updated_at = now()->timezone('Asia/Ho_Chi_Minh');

        $comment->save();
        if ($comment) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }

    public function deleteComment(Request $request){
        $id = $request->id;  

        $comment = Comment::find($id);

        $comment->delete();
        if ($comment) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }
}
