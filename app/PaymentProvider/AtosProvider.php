<?php
/**
 * User: chris
 * Date: 07/08/2016
 * Time: 15:10
 */

namespace App\PaymentProvider;

use App\Models\ImmediateTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\Config;

use App\Classes\AtosRequest;
use Illuminate\Support\Facades\Log;

class AtosProvider implements PaymentGateway
{
    public function getName()
    {
        return 'Atos';
    }

    public function getChoosePage(Transaction $transaction)
    {
        $req = $this->doAtosRequest($transaction);
        if($req->isSuccess())
            return $req->body->get('message');
        else return null;

        //TODO: Implément error reporting
    }

    public function requestPayment(Transaction $transaction)
    {
        // TODO: Implement requestPayment() method.
    }

    public function canBeUsed(Transaction $transaction):bool
    {

        //Check min an max amount
        if($transaction->amount > Config::get('transaction.atos.max_amount', 100000) || $transaction->amount < Config::get('payment.atos.min_amount',100))
            return false;
        if(!$transaction instanceof ImmediateTransaction)
            return false;

        return true;
    }

    protected function doAtosRequest(Transaction $transaction)
    {
        $parameters = [
            'customer_email' => $transaction->client_mail,
            'capture_day' => $transaction->capture_day,
            'caddie' => $transaction->id,
        ];

        $request = new AtosRequest(Config::get('payment.atos.merchand_id'), 'fr', Config::get('payment.atos.pathfile'), Config::get('payment.atos.requestPath'), Config::get('payment.atos.responsePath'), Config::get('payment.atos.isDebug'));
        return $request->requestGetCheckoutToken($transaction->amount, Config::get('atos.currencies'), $transaction->getAtosParameter());
    }

    public function processCallback($encryptedData)
    {
        $request = new AtosRequest(Config::get('payment.atos.merchand_id'), 'fr', Config::get('payment.atos.pathfile'), Config::get('payment.atos.requestPath'), Config::get('payment.atos.responsePath'), Config::get('payment.atos.isDebug'));
        $req = $request->requestDoCheckoutPayment($encryptedData);

        if($req->isSuccess())
            if($transaction = Transaction::find($req->body->get('caddie')))
            {
                $transaction->data = json_encode($req->body->all());
                $transaction->bank_transaction_id = $req->body->get('transaction_id');

                if($req->body->get('amount') != $transaction->amount)
                {
                    throw new \Exception('Discordance in transaction amount');
                    $transaction->save();
                    Log::critical('Discordance in transaction amout '.$transaction->id);
                    return false;
                }
                switch ($transaction->body->get('response_code'))
                {
                    case '00': // Accepted
                        $transaction->callbackAccepted();
                        break;

                    case '05': //Refused
                        $transaction->callbackRefused();
                        break;

                    case '17': // Canceled
                        $transaction->callbackCanceled();
                        break;
                    default:
                        Log::warning('Inconnu atos return code. '.$transaction->id);

                }

                $transaction->save();
                return $transaction;
            }
    }
}