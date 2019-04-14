<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorties extends Model
{
    public $table = 'favorites';
    public $timestamps = true;
    protected $fillable = ['id','user_id','meal_id'];
    protected $hidden   = ['created_at','updated_at'];
}