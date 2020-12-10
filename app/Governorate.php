<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{

    protected $table = 'governorates';
    protected $fillable = ['name'];
    public $timestamps = true;

//    public function cities()
//    {
//        return $this->belongsToMany('App\City');
//    }

}