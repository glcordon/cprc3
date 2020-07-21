<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Note extends Model
{
    protected $table = 'notes';
    protected $guarded = [];
    
    public function client()
    {
        return $this->belongsTo('\App\Client', 'client_id', 'id');
    }
}
