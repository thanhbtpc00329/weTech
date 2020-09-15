<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey="cate_id";
    protected $table="categories";
    protected $fillable=['cate_name','cate_description','image','category','status'];
    public $timestamps=false;
}
