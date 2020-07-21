<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Job extends Model
{
    protected $guarded = [];
    protected $table = "Jobs";
    
    
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
}
