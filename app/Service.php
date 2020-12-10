<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {

	protected $table = 'services';
	public $timestamps = true;
	protected $fillable = array('name', 'price', 'image');

	public function client()
	{
		return $this->belongsTo('Client');
	}

    public function category()
    {
        return $this->belongsTo('Category');
    }

}