<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['comment', 'rating', 'service_id', 'user'];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
