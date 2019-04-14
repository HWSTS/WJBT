<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'user';
    public $timestamps = true;
    protected $fillable = ['id','user_id','contact_number','code','province','attempts','suspended'];
    protected $hidden   = ['id','code','created_at','updated_at'];
}