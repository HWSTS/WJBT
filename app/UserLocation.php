<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    public $table = 'user_location';
    public $timestamps = false;
    protected $fillable = ['id','uid','province','name','location','lat','long'];
    protected $hidden   = ['uid',];
}