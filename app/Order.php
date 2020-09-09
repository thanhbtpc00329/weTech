<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey="id";
    protected $table="orders";
    protected $fillable=['username','address','shipping','total','status','order_detail'];
    public $timestamps=true;
}
