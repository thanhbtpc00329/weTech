<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    protected $primaryKey="id";
    protected $table="product_image";
    protected $fillable=['prodetail_id','image'];
    public $timestamps=false;
}
