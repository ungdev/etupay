<?php

namespace App\PaymentProvider;

use App\Models\AuthorisationTransaction;
use App\Models\Transaction;

class PaypalProvider implements PaymentGateway
{
    public function canBeUsed(Transaction $transaction):bool
    {
        if($transaction->amount<=0)
            return false;

        if(!$transaction instanceof AuthorisationTransaction)
            return false;

        return true;
    }

    public function requestPayment(Transaction $transaction)
    {
        // TODO: Implement requestPayment() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function getChoosePage(Transaction $transaction)
    {
        // TODO: Implement getChoosePage() method.
    }

}