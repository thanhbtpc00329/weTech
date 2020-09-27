<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    protected $primaryKey="id";
    protected $table="shippers";
    protected $fillable=['user_id','order_qauntity','salary','status'];
    public $timestamps=false;
}
