<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $primaryKey="id";
    protected $table="bills";
    protected $fillable=['name','username','email','total'];
    public $timestamps=true;
}
