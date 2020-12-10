<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'service_id');

    public function clients()
    {
        return $this->hasMany('App\Client', 'client_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
