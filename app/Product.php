<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey="product_id";
    protected $table="products";
    protected $fillable=['name','brand_id','cate_id','introduction','description','tag','shop_id','shop','status'];
    public $timestamps=false;
}
