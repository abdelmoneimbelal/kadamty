<?php

namespace App;

class CG extends Eloquent {

	protected $table = 'client_governrate';
	public $timestamps = true;

	public function governrate()
	{
		return $this->belongsToMany('App\Governorate');
	}

	public function client()
	{
		return $this->belongsToMany('App\Client');
	}

}