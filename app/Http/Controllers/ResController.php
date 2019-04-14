<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Restaurant;
use DB;
class ResController extends Controller
{
    

    public function Store(Request $request)
    {
        $uuid = Uuid::generate()->string;
        $res = Restaurant::create(array_merge(['res_id' => $uuid],$request->all()));
        return response()->json(['status_code'=>1000,'data'=>$uuid,'message'=>"Created Successfully"],200);
    }

    public function login(Request $request)
    {
        $res = Restaurant::where('username',$request->username)->first();
        if($res){
            if($res->password == $request->password){

                return response()->json(['status_code'=>1000,'data'=>$res->res_id,'message'=>"Logged Successfully"],200);

            }else{

                return response()->json(['status_code'=>2000,'data'=>null,'message'=>"Wrong Password"],200);
            }

        }else{

            return response()->json(['status_code'=>2000,'data'=>null,'message'=>"User Not Found"],200);

        }
    }

    public function resList($province){

        $resList = DB::table('restaurant')
                     ->where('restaurant.province','=', $province)
                    ->select('restaurant.res_id','restaurant.name','restaurant.open_time','restaurant.img_url',DB::raw('(select count(meal.id) from meal where meal.res_id = restaurant.res_id) as mealNum'))
                  ->orderByRaw('RAND()')
                     ->paginate(5);
        return response()->json($resList,200);
    }

}
