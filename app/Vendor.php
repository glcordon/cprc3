<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Vendor extends Model
{
    use SoftDeletes;

    public $table = 'vendors';

    const IS_ACTIVE_SELECT = [

    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'vendor_name',
        'vendor_phone',
        'vendor_email',
        'vendor_address_1',
        'vendor_address_2',
        'vendor_city',
        'vendor_state',
        'vendor_zip',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
