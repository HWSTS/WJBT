<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Meal;
use App\Sidedish;
use DB;

class MealController extends Controller
{
    

    public function store(Request $request)
    {

        if ($request->hasFile('image')) {
            $image = $request->image;
            $name = 'MEAL'.'-'.time().'.'.'jpg';
            $destinationPath = base_path('public/images/');
            $image->move($destinationPath, $name);
            $imgurl = 'https://wajabatapp.net/images/'.$name;
            $uuid = Uuid::generate()->string;
        $meal = Meal::create(['res_id'=>$request->res_id,
                                'meal_id'=>$uuid,
                                'province'=>$request->province,
                                'category'=>$request->category,
                                'name'=>$request->name,
                                'price'=>$request->price,
                                'num_person'=>$request->num_person,
                                'discount'=>$request->discount,
                                'delv_time'=>$request->delv_time,
                                'ar_ing'=>$request->ar_ing,
                                'img_url'=>$imgurl
                                ]);
        $side = Sidedish::create(['meal_id'=>$uuid,
                                    'fries'=>$request->fries,
                                    'entree'=>$request->entree,
                                    'sauce'=>$request->sauce,
                                    'pepsi'=>$request->pepsi,
                                    'juice'=>$request->juice,
                                    'saop'=>$request->saop]);
        return response()->json(['status_code'=>1000,'data'=>null,'message'=>"Meal Created Successfully"],200);
        }
    }
    
    public function list($province)
    {
        $meals  = DB::table('meal')
        ->where('meal.province','=', $province)
        ->join('restaurant as r','r.res_id', '=','meal.res_id')
        ->join('sidedish as s','s.meal_id', '=','meal.meal_id')
        ->select('meal.res_id','meal.meal_id','meal.name as meal_name','meal.price','meal.img_url as meal_image','meal.num_orders','meal.num_person','meal.delv_time','meal.discount','meal.ar_ing','r.name as res_name','r.img_url as res_image','s.pepsi','s.juice','s.entree','s.sauce','s.saop','s.fries')
        ->orderBy('num_orders', 'desc')
        ->paginate(20);
        return response()->json($meals,200);
    }

    public function reslist($uid)
    {
        $meals  = DB::table('meal')
        ->where('meal.res_id','=', $uid)
        ->select('meal.id','meal.category','meal.name','meal.price','meal.img_url','meal.num_orders','meal.num_person','meal.delv_time','meal.discount','meal.ar_ing')
        ->orderByRaw('created_at','asc')
        ->get();
        return response()->json(['status_code'=>1000,'data'=>$meals , 'message'=>null],200);
    }

    public function search($category, $province)
    {
        $meal = Meal::where('category',$category)
                    ->where('province',$province)
                    ->orderBy('num_orders', 'desc')
                    ->paginate(20);
        return response()->json($meal,200);
    }

    public function update(Request $request)
    {
        $meal = Meal::where('id',$request->id)->first();
        $meal->price = $request->price;
        $meal->discount = $request->discount;
        $meal->delv_time = $request->delv_time;
        $meal->ar_ing = $request->ar_ing;
        $meal->save();
        return response()->json(['status_code'=>1000,'data'=>null , 'message'=>'Updated Successfully'],200);
    }

    public function delete(Request $request)
    {
        $meal = Meal::where('meal_id',$request->meal_id)->first();
        if($meal){
            $meal = Meal::where('meal_id',$request->meal_id)->delete();
            $side = Sidedish::where('meal_id',$request->meal_id)->delete();
            return response()->json(['status_code'=>1000,'data'=>null , 'message'=>'Deleted Successfully'],200);
        }else{
            return response()->json(['status_code'=>2000,'data'=>null , 'message'=>'Meal Not Exist'],200);
        }
        
    }

}
