<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adds extends Model
{
    public $table = 'adds';
    protected $fillable = ['id','type','img_url','link'];
    protected $hidden   = ['id'];
}