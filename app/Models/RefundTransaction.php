<?php


namespace App\Models;


class RefundTransaction extends Transaction
{
    protected $type = 'refund';

    public function __construct()
    {
        $this->attributes['type'] = 'REFUND';
        $this->attributes['capture_day'] = 29;
        parent::__construct();
    }

    protected static function boot()
    {
        static::addGlobalScope(new TransactionScope('refund'));
        parent::boot();
    }
}