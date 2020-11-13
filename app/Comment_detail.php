<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment_detail extends Model
{
    protected $primaryKey="id";
    protected $table="comment_detail";
    protected $fillable=['shop_id','cmt_id','content','product_id','status'];
    public $timestamps=false;
}
