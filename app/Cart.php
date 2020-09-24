<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey="cart_id";
    protected $table="carts";
    protected $fillable=['cart_id','user_id'];
    public $timestamps=false;
}
