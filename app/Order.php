<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'order';
    public $timestamps = true;
    protected $fillable = ['id','oid','user_id','res_id','meal_id','qty','price','subtotal','user_location','user_number','status','pay_status'];
    protected $hidden   = ['id','user_id','res_id','updated_at'];
}