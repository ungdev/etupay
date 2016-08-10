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
}