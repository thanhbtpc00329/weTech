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
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $content = $request->content;
        $product_id = $request->product_id;
        $rating = $request->rating;
        $status = $request->status;

        $comment = new Comment;
        $comment->name = $name;
        $comment->username = $username;
        $comment->email = $email;
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

    public function updateComment(Request $request){
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
