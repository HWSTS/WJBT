<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Order;
use App\Meal;
use DB;
class OrderController extends Controller
{
    
    public function store(Request $request)
    {
        $order = Order::create(array_merge($request->all(),['oid'=> $this->generateOID()]));
        $meal = Meal::where('meal_id',$request->meal_id)->first();
        $meal->num_orders = $meal->num_orders + 1;
        $meal->save();
        return response()->json(['status_code'=>1000,'data'=>null,'message'=>"تم ارسال الطلب بنجاح"],200);

    }


    function update(Request $request)
    {
        $order = Order::where('id',$request->id)->first();
        if($order){
             if($order->status == 3){
            return response()->json(['status_code'=>1000,'data'=>null,'message'=>"Can't Update        Delievered Order"],200);
                
            }else{
                $order->status = $request->status;
                $order->save();
                return response()->json(['status_code'=>1000,'data'=>null,'message'=>"Updated Successfully"],200);
            }
            
        }

    }


    public function userOrder($uid)
    {
        $orders = DB::table('order')
        ->where('order.user_id','=', $uid)
        ->join('meal as m','m.meal_id', '=','order.meal_id')
        ->select('order.oid','order.price','order.qty','order.subtotal','order.status','order.created_at','m.name','m.img_url')
        ->orderByRaw('created_at','asc')
        ->take(30)
        ->get();
        return response()->json(['status_code'=>1000,'data'=>$orders,'message'=>null],200);
    }

    public function resOrder($uid, $status)
    {
        $orders = DB::table('order')
        ->where('order.res_id','=', $uid)
        ->where('order.status','=',$status)
        ->join('meal as m','m.meal_id', '=','order.meal_id')
        ->select('order.id','order.oid','order.price','order.qty','order.subtotal','order.status','order.user_location','order.user_number','order.created_at','m.name')
        ->orderByRaw('created_at','asc')
        ->get();
      
        
        return response()->json(['data'=>$orders],200);
    }


    public function penOrders($uid)
    {
        $orders = DB::table('order')
        ->where('order.res_id','=', $uid)
        ->where('order.status','=', 1)
        ->orWhere('order.status','=', 2)
        ->join('meal as m','m.meal_id', '=','order.meal_id')
        ->select('order.id','order.oid','order.price','order.qty','order.subtotal','order.status','order.user_location','order.user_number','order.created_at','m.name')
        ->orderByRaw('created_at','asc')
        ->get();
      
        
        return response()->json(['data'=>$orders],200);
    }

    public function account($uid, $fromdate, $todate)
    {
        // $account = DB::table('order')
        //             ->select(DB::raw('COUNT(order.id) as count, Sum(order.subtotal) as sum'),'status')
        //             ->whereBetween('created_at',[$fromdate, $todate])
        //             ->whereIn('status',[0,1,2,3,4,5])
        //             ->groupBy('status')
        //             ->get();

        $account = DB::table('order')
                    ->where('order.res_id','=', $uid)
                    ->whereBetween('order.created_at',[$fromdate, $todate])
                    ->join('meal as m','m.meal_id', '=','order.meal_id')
                     ->select('order.id','order.oid','order.price','order.qty','order.subtotal','order.status','order.user_location','order.user_number','order.created_at','m.name')
                     ->orderByRaw('created_at','asc')
                    ->get();

         return response()->json(['data'=>$account],200);
    }



    private function generateOID()
    {
        $unique_ref_length = 6;  
        $possible_chars = "019283746546372819";
        
  
            $unique_ref = "";  
            
            $i = 0;  
            
            while ($i < $unique_ref_length) {  
          
                 
                $char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);  
                
                $unique_ref .= $char;  
                
                $i++;  
            }

        return $unique_ref;
    } 

}
