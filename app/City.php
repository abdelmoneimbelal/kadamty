<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'governrate_id'];

    public function governrate(){

        return $this->belongsTo('App\Governorate','governrate_id');

    }

//    public function clients()
//    {
//        return $this->hasOne('App\Client');
//    }

}
