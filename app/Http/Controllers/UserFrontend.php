<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserFrontend extends Controller
{
    public function paymentGatewayChoice(Request $request, Transaction $transaction)
    {
        $gws = $this->getPaymentGateway($transaction);
        foreach ($gws as $gw)
        {
            echo $gw->getChoosePage($transaction);
        }
    }

    protected function getPaymentGateway(Transaction $transaction)
    {
        $providers = [];
        foreach (config('payment.gateway') as $gateway)
        {
            $provider = new $gateway;
            if($provider->canBeUsed($transaction))
                $providers[] = $provider;

        }
        return $providers;
    }
}
