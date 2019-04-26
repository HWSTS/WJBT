<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\User;
use App\UserLocation;
use Twilio\Jwt\ClientToken;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $contact_number = $request->contact_number;
        $user = User::where('contact_number',$contact_number)->first();
        if($user){

            if($user->attempts == 15){
                // suspended user message
                return response()->json(['status_code'=>3000,'data'=>null , 'message'=>"تم تعليق حسابك ... يرجى الاتصال بخدمة العملاء"],200);
            }else{

                //update attempts and code and send sms (NO NEED FOR PROFILE STSTUS 1000)
                $code = rand(1010,9999);
                $user->code = $code;
                $user->attempts = $user->attempts + 1;
                $user->save();
                $this->sendSMS($contact_number, $code);
                return response()->json(['status_code'=>2000,'data'=>null,'message'=>"Already User"],200);
                
            }

        }else{
                // new user go to signup
            return response()->json(['status_code'=>1000,'data'=>null , 'message'=>"مستخدم جديد ! ... يرجى الذهاب الى انشاء حساب اولا"],200);
        }
    }

    public function signup(Request $request)
    {
        $contact_number = $request->contact_number;
        $user = User::where('contact_number',$contact_number)->first();
        if(!$user){
        $uuid = Uuid::generate()->string;
        $code = rand(1010,9999);
        $user = User::create(array_merge( ['user_id' => $uuid],['contact_number'=> $contact_number],['code'=>$code],['province'=>$request->province]));
        $this->sendSMS($contact_number, $code);
        return response()->json(['status_code'=>1000, 'data'=>null,'message'=>"New User"],200);
        }else{
            return response()->json(['status_code'=>2000, 'data'=>null,'message'=>"لقد قمت بالتسجيل مسبقا ... يرجى الذهاب الى تسجيل الدخول"],200);
        }
    }

    public function verfiy(Request $request)
    {
        $contact_number = $request->contact_number;
        $user = User::where('contact_number', $contact_number)->first();
        if($user){

            if($user->code == $request->code){
            
            
                return response()->json(['status_code'=>1000,'data'=>['user_id'=>$user->user_id, 'province'=>$user->province] , 'message'=>"Verified"],200);
            
            
        }else{
            // return wrong code response
            return response()->json(['status_code'=>2000,'data'=>null , 'message'=>"رمز التفعيل خاطئ ... يرجى التأكد"],200);
        }
        }
        
    }

    function updateLocation(Request $request){
        $user = User::where('user_id',$request->user_id)->first();
        if($user){
            $user->province = $request->province;
            $user->save();
            return response()->json(['status_code'=>1000,'data'=>null , 'message'=>"تم تحديث الموقع"],200);
        }
    }

    function sendSMS(String $contact_number, String $code)
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        try
        {
        $client = new Client(['auth' => [$accountSid, $authToken]]);
        $result = $client->post('https://api.twilio.com/2010-04-01/Accounts/'.$accountSid.'/Messages.json',
        ['form_params' => [
        'Body' => 'رمز التفعيل الخاص بك هو : '. $code, //set message body
        'To' => $contact_number,
        'From' => '+18302181985' //we get this number from twilio
        ]]);
        return $result;
        }
        catch (Exception $e)
        {
        echo "Error: " . $e->getMessage();
        }
    }
}
