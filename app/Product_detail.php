<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_detail extends Model
{
    protected $primaryKey="prodetail_id";
    protected $table="product_detail";
    protected $fillable=['product_id','price','color','quantity','size','status','discount_price'];
    public $timestamps=false;
}
