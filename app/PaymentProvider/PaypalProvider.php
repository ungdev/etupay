<?php

namespace App\PaymentProvider;

use Illuminate\Http\Request;
use App\Models\AuthorisationTransaction;
use App\Models\Transaction;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Config;

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
        return 'Paypal';
    }

    public function getChoosePage(Transaction $transaction)
    {
        //return route('userFrontend.paypalRedirect', ['InitialisedTransaction' => $transaction]);
        return view('gateways.paypal.basket', ['url' => route('userFrontend.paypalRedirect', ['InitialisedTransaction' => $transaction])]);
    }

    public function processCallback(Request $request)
    {
        if($request->query('paymentId'))
        {
            $payment = Payment::get($request->query('paymentId'), $this->getPaypalApiContext());
            $execution = new PaymentExecution();
            $execution->setPayerId($request->query('PayerID'));
            if($transaction = Transaction::find($payment->transactions[0]->custom))
            {
                $transaction->provider = $this->getName();
                if($payment->state == 'created') {
                    try {
                        $payment->execute($execution, $this->getPaypalApiContext());
                    } catch (\Exception $e)
                    {
                        die($e->getData());
                    }
                    $transaction->bank_transaction_id = $payment->id;
                    switch ($payment->state)
                    {
                        case 'approved':
                            $transaction->data = $payment->toJSON();
                            $transaction->callbackAccepted();
                            break;
                        case 'failed':
                            $transaction->data = $payment->toJSON();
                            $transaction->callbackRefused();
                            break;
                    }
                }

                return $transaction;

            }else
                throw new \Exception("Can't find transaction attached to request");
        }else
            throw new \Exception("Incorrect return");
    }

    public function getAuthorizeUrl(Transaction $transaction)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal($transaction->amount/100);

        $pTransaction = new \PayPal\Api\Transaction();
        $pTransaction->setAmount($amount)
            ->setDescription($transaction->description)
            ->setCustom($transaction->id);
         //   ->setNotifyUrl(url()->route('callback.paypal'));

        $redirectUrl = new RedirectUrls();
        $redirectUrl->setReturnUrl(url()->route('return.paypal'))
            ->setCancelUrl(url()->route('userFrontend.choose', ['InitialisedTransaction' => $transaction]));

        $payment = new Payment();
        $payment->setIntent('authorize')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrl)
            ->setTransactions([$pTransaction]);

        try{
            $payment->create($this->getPaypalApiContext());
        } catch (\Exception $ex)
        {
            throw new \Exception('Can\'t create paypal request.');
        }

        return $payment->getApprovalLink();
    }

    private function getPaypalApiContext()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                Config::get('payment.paypal.clientId'),
                Config::get('payment.paypal.clientSecret')
            )
        );

        $apiContext->setConfig(
            array(
                'mode' => 'sandbox',
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/PayPal.log'),
                'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true,
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
                //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
            )
        );

        return $apiContext;
    }

}