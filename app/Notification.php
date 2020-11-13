<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey="id";
    protected $table="notifications";
    protected $fillable=['order_id','message','type'];
    public $timestamps=false;
}
