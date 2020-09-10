<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    protected $primaryKey="id";
    protected $table="shippers";
    protected $fillable=['name','username','delivery_address','user_id','status'];
    public $timestamps=false;
}
