<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $primaryKey="id";
    protected $table="bills";
    protected $fillable=['prodetail_id','sale_quantity','shop_id','status'];
    public $timestamps=false;
}
