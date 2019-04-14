<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Favorties;
use DB;
class FavController extends Controller
{
    
    public function store(Request $request)
    {
        $fav = Favorties::where('meal_id',$request->meal_id)->first();
        if($fav){
             return response()->json(['status_code'=>2000,'data'=>null , 'message'=>'الوجبة مضافة الى المفضلة مسبقا'],200);
        }else{

            $fav = Favorties::create($request->all());
            return response()->json(['status_code'=>1000,'data'=>null , 'message'=>'تمت الاضافة الى المفضلة'],200);
        }
    }


    public function list($uid)
    {
        $meals  = DB::table('favorites')
        ->where('favorites.user_id','=', $uid)
        ->join('meal','favorites.meal_id','=','meal.meal_id')
        ->join('restaurant as r','r.res_id', '=','meal.res_id')
        ->join('sidedish as s','s.meal_id', '=','meal.meal_id')
        ->select('meal.res_id','meal.meal_id','meal.name as meal_name','meal.price','meal.img_url as meal_image','meal.num_orders','meal.num_person','meal.delv_time','meal.discount','meal.ar_ing','r.name as res_name','r.img_url as res_image','s.pepsi','s.juice','s.entree','s.sauce','s.saop','s.fries')
        ->orderByRaw('created_at')
        ->paginate(5);
        return response()->json($meals,200);
    }



}
