<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class PaymentLoader extends Facade
{
    protected static function getFacadeAccessor() { return 'PaymentLoader'; }
}