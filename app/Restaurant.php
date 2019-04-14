<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public $table = 'restaurant';
    public $timestamps = true;
    protected $fillable = ['id','res_id','name','province','img_url','contact_number','open_time','username','password'];
    protected $hidden   = ['id','username','password','created_at','updated_at'];
}