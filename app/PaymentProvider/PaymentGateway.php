<?php

namespace App\PaymentProvider;

use App\Models\Transaction;

interface PaymentGateway
{
    public function requestPayment(Transaction $transaction);
    public function canBeUsed(Transaction $transaction):bool ;

    public function getName();
    public function getChoosePage(Transaction $transaction);

}