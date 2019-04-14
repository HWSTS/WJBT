<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Offer;
use App\Restaurant;
use DB;

class OfferController extends Controller
{
    
    public function Store(Request $request)
    {
        $res = Restaurant::where('uid',$request->uid)->first();
        if(!$res){
            $offer = Offer::create($request->all());
            return response()->json(['status_code'=>1000,'data'=>null,'message'=>"Created Successfully"],200);
        }else{
            return response()->json(['status_code'=>2000,'data'=>null,'message'=>"You Already Have 1 Offer"],200);
        }
    }


    public function list($province)
    {
        // $offers = Offer::where('province',$province)
        //                 ->orderBy('num_orders', 'desc')
        //                 ->paginate(5);
        // return response()->json($offers,200);

        $offers = DB::table('offer')
        ->where('offer.province','=', $province)
        ->join('restaurant as r','r.uid', '=','offer.uid')
        ->join('sidedish as s','s.meal_id', '=','offer.meal_id')
        ->select('offer.uid','offer.meal_id','offer.name as meal_name','offer.price','offer.img_url as meal_image','offer.num_orders','offer.num_person','offer.delv_time','offer.discount','offer.ar_ing','r.name as res_name','r.img_url as res_image','s.pepsi','s.juice','s.entree','s.sauce','s.saop','s.fries')
        ->orderByRaw('RAND()')
        ->paginate(5);
        return response()->json($offers,200);
    }


    public function delete($id)
    {
        $offer = Offer::where('id',$id)->delete();
        return response()->json(['status_code'=>1000,'data'=>null , 'message'=>'Deleted Successfully'],200);
    }

}
