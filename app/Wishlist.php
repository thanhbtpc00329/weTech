<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $primaryKey="id";
    protected $table="wishlists";
    protected $fillable=['username','product_name','product_image','product_id'];
    public $timestamps=false;
}
