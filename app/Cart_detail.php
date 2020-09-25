<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart_detail extends Model
{
    protected $primaryKey="cart_detail_id";
    protected $table="cart_detail";
    protected $fillable=['cart_id','prodetail_id','cart_quantity','shop_id'];
    public $timestamps=false;
}
