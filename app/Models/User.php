<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'services_users');
    }

    public function getAdminTransactionsQuery()
    {
        return $this->getAdminServicesQuery()
            ->join('transactions', 'services.id', '=', 'transactions.service_id');
    }

    public function getAdminServicesQuery()
    {
        if($this->isSuperAdmin)
        {
            return Service::query();
        } else {
            return $this->services();
        }
    }
}
