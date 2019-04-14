<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public $table = 'meal';
    public $timestamps = true;
    protected $fillable = ['id','res_id','meal_id','province','category','name','price','img_url','num_orders','num_person','discount','delv_time','ar_ing'];
    protected $hidden   = ['province','category','created_at','updated_at'];
}