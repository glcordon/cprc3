<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    

    public function servicesVendors()
    {
        return $this->belongsToMany(Vendor::class);
    }
}

