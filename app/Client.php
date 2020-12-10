<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'phone', 'email', 'address', 'password', 'city_id', 'pin_code');


    public function city()
    {
        return $this->belongsTo('App\Client');
    }

    public function orders()
    {
        return $this->belongsTo('App\Order');
    }


    protected $hidden = [
        'password', 'api_token'
    ];

}