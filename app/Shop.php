<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $primaryKey="shop_id";
    protected $table="shops";
    protected $fillable=['shop_name','user_id','address','location','phone_number','identity_card','tax','background'];
    public $timestamps=false;
}
