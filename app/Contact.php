<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $primaryKey="id";
    protected $table="contacts";
    protected $fillable=['name','email','title','content','status'];
    public $timestamps=false;
}
