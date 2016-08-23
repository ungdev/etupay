<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\PaymentProvider\AtosProvider;
use App\PaymentProvider\PaypalProvider;
use Illuminate\Http\Request;
use App\Facades\PaymentLoader;


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

    public function paypalCallback(Request $request)
    {
        $provider = new PaypalProvider();
        if($transaction = $provider->processCallback($request))
        {
            $payload = PaymentLoader::encryptFromService($transaction->service, $transaction->callbackReturn());
            return redirect($transaction->service->return_url.'?payload='.$payload);
        }
    }

    public function paypalRedirect(Transaction $transaction)
    {
        $paypal = new PaypalProvider();
        if(!$paypal->canBeUsed($transaction))
            abort(402, "Can't use Paypal for this transaction");

        return redirect($paypal->getAuthorizeUrl($transaction));
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
