<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    //
    protected $table = "client_service";
    protected $guarded = [];
    public $timestamps = true;
}
