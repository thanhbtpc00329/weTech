<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $primaryKey="id";
    protected $table="statistic";
    protected $fillable=['month','year','sta_total','shop_id'];
    public $timestamps=false;
}
