<?php

namespace App;

class Token extends Eloquent {

	protected $table = 'tokens';
	public $timestamps = true;
	protected $fillable = array('token', 'type');

}