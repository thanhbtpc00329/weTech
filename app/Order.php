<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey="id";
    protected $table="orders";
    protected $fillable=['user_id','order_address','shipping','user_range','total','shop_id','shipper_deliver','shipper_receive','status','order_detail','note'];
    public $timestamps=false;
}
