<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResLocation extends Model
{
    public $table = 'res_location';
    public $timestamps = false;
    protected $fillable = ['id','res_id','province','name','lat','long'];
    protected $hidden   = ['id','res_id','province'];
}