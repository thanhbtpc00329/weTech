<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification_shiper extends Model
{
    protected $primaryKey="id";
    protected $table="notification_shipper";
    protected $fillable=['order_id','message','type'];
    public $timestamps=false;
}
