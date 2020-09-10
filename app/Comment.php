<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey="id";
    protected $table="comments";
    protected $fillable=['name','username','email','content','product_id','rating','status'];
    public $timestamps=false;
}
