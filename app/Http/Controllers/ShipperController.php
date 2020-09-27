<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipper;
use App\User;

class ShipperController extends Controller
{
    //Shipper
    public function showShipper()
    {
    	$ship = User::where('role','Shipper')->get();
        return $ship;
    }

    public function detailShipper(){
    	$ship = DB::table('shippers')
    			->join('users','users.user_id','=','shippers.user_id')
    			->get();
    	return $ship;
    }
}
