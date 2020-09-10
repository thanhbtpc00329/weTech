<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $primaryKey="id";
    protected $table="shops";
    protected $fillable=['name','address','location','phone_number'];
    public $timestamps=false;
}
