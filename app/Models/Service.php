<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = ['fundation_id', 'host', 'api_key', 'return_key', 'cancel_url', 'callback_url'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($user){
            $user->generateApiKey();
        });
    }

    public function fundation()
    {
        return $this->hasOne('App\Fundation');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function generateApiKey()
    {
        $this->attributes['api_key'] = base64_encode(\openssl_random_pseudo_bytes(32));
    }
}
