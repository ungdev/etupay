<?php


namespace App\Models;


class RefundTransaction extends Transaction
{
    protected $type = 'refund';

    public function bind($data)
    {
        parent::bind($data);
        $this->attributes['type'] = 'REFUND';
        $this->attributes['capture_day'] = 29;
    }

    protected static function boot()
    {
        static::addGlobalScope(new TransactionScope('refund'));
        parent::boot();
    }
}