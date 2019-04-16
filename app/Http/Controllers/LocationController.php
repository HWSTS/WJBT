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

    public function store(Request $request)
    {
        $locations = ResLocation::create($request->all());
        return response()->json(['status_code'=>1000,'data'=>null , 'message'=>'Location Saved Successfully'],200);
    }


   
}
