<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Service extends Model
{
    protected $table = 'services';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsToMany('\App\Client', 'client_service', 'service_id', 'client_id')->withPivot(['created_at', 'updated_at']);
    }
}
