<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\ResLocation;

class LocationController extends Controller
{
    
    public function list($uid)
    {
        $locations = ResLocation::where('res_id',$uid)
                                ->get();
        return response()->json(['status_code'=>1000,'data'=>$locations , 'message'=>null],200);
    }


    // 1- add user location
    // 2- list user locations
    // 3- add res location 
    // 4- get list of restaurants locations + center of province
}
