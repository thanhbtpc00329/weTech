<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey="id";
    protected $table="orders";
    protected $fillable=['user_id','address','shipping','total','shop_id','shipper_id','status','order_detail'];
    public $timestamps=false;
}
