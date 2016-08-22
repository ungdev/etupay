<?php


namespace App\Models;


class AuthorisationTransaction extends Transaction
{
    protected $type = 'authorisation';

    public function bind($data)
    {
        parent::bind($data);
        $this->attributes['type'] = 'AUTHORISATION';
        $this->attributes['capture_day'] = 29;
    }

    protected static function boot()
    {
        static::addGlobalScope(new TransactionScope('authorisation'));
        parent::boot();
    }
}