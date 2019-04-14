<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sidedish extends Model
{
    public $table = 'sidedish';
    public $timestamps = false;
    protected $fillable = ['id','meal_id','pepsi','juice','entree','fries','sauce','saop'];
    protected $hidden   = ['id'];
}