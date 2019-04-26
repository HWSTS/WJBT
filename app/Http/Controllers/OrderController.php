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
                if($request->status == 2){
                    $this->sendNotification($order->user_id);
                }
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


    public function sendNotification(String $user_id)
    {
        $content = array(
			"en" => 'وجبتك جاهزة و جايتك بالطريق'
			);
		
		$fields = array(
			'app_id' => "e138640d-d830-4b6c-93e8-1f37c96bf8b7",
			'include_external_user_ids' => array($user_id),
			'data' => array("foo" => "bar"),
			'contents' => $content
		);
		
		$fields = json_encode($fields);
    
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		//return $response;
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
