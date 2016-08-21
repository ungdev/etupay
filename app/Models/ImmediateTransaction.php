<?php


namespace App\Models;

use App\Classes\AtosRequest;
class ImmediateTransaction extends Transaction
{
    protected $type = 'checkout';

    public function bind($data)
    {
        parent::bind($data);
        $this->attributes['type'] = 'PAYMENT';
        $this->attributes['capture_day'] = 0;
    }
    public function getAtosParameter()
    {
        $param = [];
        return array_merge(parent::getAtosParameter(), $param);
    }

    protected static function boot()
    {
        static::addGlobalScope(new TransactionScope('payment'));
        parent::boot();
    }
}