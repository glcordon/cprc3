<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;


class Note extends Model
{
    protected $table = 'notes';
    protected $guarded = [];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function client()
    {
        return $this->belongsTo('\App\Client', 'client_id', 'id');
    }
}
