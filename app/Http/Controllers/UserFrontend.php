<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\PaymentProvider\AtosProvider;
use Illuminate\Http\Request;
use App\Facades\PaymentLoader;
use App\Http\Requests;

class UserFrontend extends Controller
{
    public function paymentGatewayChoice(Request $request, Transaction $transaction)
    {
        $gws = $this->getPaymentGateway($transaction);
        echo $request->getClientIp();
        foreach ($gws as $gw)
        {
            echo $gw->getChoosePage($transaction);
        }
    }

    public function atosCallback(Request $request)
    {
        $provider = new AtosProvider();
        //if($transaction = $provider->getTransactionFromCallback($request->input('DATA')))
        if($transaction = $provider->processCallback($request->input('DATA')))
        {
            $payload = PaymentLoader::encryptFromService($transaction->service, $transaction->callbackReturn());
            return redirect($transaction->service->return_url.'?payload='.$payload);
        }
    }

    protected function getPaymentGateway(Transaction $transaction)
    {
        //$transaction->callbackAccepted();
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
