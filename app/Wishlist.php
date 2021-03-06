<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $primaryKey="id";
    protected $table="wishlists";
    protected $fillable=['user_id','product_id'];
    public $timestamps=false;
}
