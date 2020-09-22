<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $primaryKey="id";
    protected $table="bills";
    protected $fillable=['product_id','sale_amount','status'];
    public $timestamps=false;
}
