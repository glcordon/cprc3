<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $casts = ['assinged_to' => 'integer', 'client_services' => 'array'];
    protected $fillable = ['user_id', 'client_services', 'assigned_to'];
    protected $dates = ['created_at', 'updated_at','deleted_at'];

    public function caseworker()
    {
        return $this->hasOne('App\User', 'id', 'case_worker');
    }
    public function profile()
    {
        return $this->hasOne('App\ClientProfile', 'user_id', 'user_id');
    }
    public function assignedTo()
    {
        return $this->hasOne('App\User', 'id', 'assigned_to');
    }
    public function services()
    {
        return $this->belongsToMany('App\Services', 'client_service', 'client_id', 'service_id')->withTimestamps()
            ->withPivot(['id','created_at', 'updated_at', 'notes', 'date_authorized', 'authorized_price', 'file_url']);
    }
    public function servicesMonth($service)
    {
        return $this->belongsToMany('App\Services', 'client_service', 'client_id', 'service_id')->withTimestamps()
            ->withPivot(['id','created_at', 'updated_at', 'notes', 'date_authorized', 'authorized_price']);
    }
    public function notes()
    {
        return $this->hasMany('App\Note')->orderBy('created_at', 'DESC');
    }
    public function jobs()
    {
        return $this->hasMany('App\Job');
    }
    
}
