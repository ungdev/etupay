<?php

namespace App\PaymentProvider;

use App\Models\AuthorisationTransaction;
use App\Models\ImmediateTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\Config;

use App\Classes\AtosRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Payline\PaylineSDK;

class PaylineProvider implements PaymentGateway
{
    private $sdk;

    public function __construct()
    {
        $this->sdk = new PaylineSDK(config('payment.payline.merchant_id'), config('payment.payline.acces_key'), null, null, null, null, (config('payment.payline.env') == 'PROD'?PaylineSDK::ENV_PROD:PaylineSDK::ENV_HOMO));
    }

    public function getName()
    {
        return 'Payline';
    }

    public function processCallback(string $token):Transaction
    {
        $req = $this->sdk->getWebPaymentDetails(['token' => $token]);

        if(!isset($req['result']['code']))
            throw new \Exception('Missing payline return.');

        if(!isset($req['privateDataList']['privateData'][0]['value']))
            throw new \Exception('Missing payline privateData.');

        if(!$transaction = Transaction::find($req['privateDataList']['privateData'][0]['value']))
            throw new \Exception('No transaction found.');

            if($transaction->step != 'INITIALISED')
            {
                Log::info('Transaction '.$transaction->id.' already processed. ABORDING');
                return $transaction;
            }

            $transaction->data = json_encode($req);
            $transaction->bank_transaction_id = $req['transaction']['id'];
            $transaction->provider = $this->getName();

            switch ($req['result']['code'])
                {
                    case '00000': // Accepted
                case '02400':
                case '02500':
                case '02501':
                case '02517':
                case '02520':
                case '02616':
                case '03000':
                case '04000':
                        if($req['payment']['amount'] != $transaction->amount)
                        {
                            throw new \Exception('Discordance in transaction amount');
                            $transaction->save();
                            Log::critical('Discordance in transaction amount '.$transaction->id);
                            return false;
                        }
                        $transaction->callbackAccepted();
                        break;
                case '02324':
                    //Transaction expiré
                    $transaction->step = 'CANCELED';
                    $transaction->save();
                    break;
                    default:
                        $transaction->callbackRefused();

                }

                Log::info('Processing callback transaction '.$transaction->id);
                $transaction->save();
                return $transaction;
    }

    public function getChoosePage(Transaction $transaction)
    {
        if($request = $this->doWebRequest($transaction)) {
            return view('gateways.payline.basket', [
                'transaction' => $transaction,
                'payline_token' => $request['token']
            ]);
        } else return null;
    }

    public function requestPayment(Transaction $transaction)
    {
        // TODO: Implement requestPayment() method.
    }

    public function canBeUsed(Transaction $transaction):bool
    {
        //Chek min
        if($transaction->amount > Config::get('transaction.atos.max_amount', 100000) || $transaction->amount < Config::get('payment.atos.min_amount',100))
            return false;

        return true;
    }

    protected function doWebRequest(Transaction $transaction)
    {
        $param = [];

        $param['returnURL'] = url()->route('return.payline');
        $param['cancelURL'] = url()->route('return.payline');

        //URL::forceRootUrl('http://46d42550.ngrok.io');
        $param['notificationURL'] = url()->route('callback.payline');
        $param['securityMode'] = 'SSL';

        $param['payment']['amount'] = $transaction->amount;
        $param['payment']['currency'] = 978;
        $param['payment']['mode'] = 'CPT';

        if($transaction instanceof ImmediateTransaction)
            $param['payment']['action'] = 101;
        if($transaction instanceof AuthorisationTransaction)
            $param['payment']['action'] = 100;

        $param['order']['ref'] = 'etupay_'.$transaction->id;
        $param['order']['amount'] = $transaction->amount;
        $param['order']['currency'] = 978;
        $param['order']['date'] = $transaction->created_at->format('d/m/Y H:i');

        $param['buyer'] = [
            'lastName' => $transaction->lastname,
            'firstName' => $transaction->firstname,
            'email' => $transaction->client_mail,
        ];
        $param['shippingAddress'] = $param['billingAddress'] = [];
        $param['payment']['contractNumber'] = config('payment.payline.contract_number');
        $param['owner'] = $param['ownerAddress'] = [];

        $this->sdk->addPrivateData(['key' => 'etupay_id', 'value'=> $transaction->id]);
        $return = $this->sdk->doWebPayment($param);
        if($return['result']['code'] == '00000')
            return $return;
        else {
            Log::error("PaylineProvider - Transaction ".$transaction->id." - ".$return['result']['code'].": ".$return['result']['longMessage']);
            return false;
        }


    }

    public function getHumanisedReport(Transaction $transaction)
    {
        $trs = json_decode($transaction->data);
        if($transaction instanceof ImmediateTransaction && $transaction->step == 'PAID')
        {
            return "Transaction par carte bancaire n°".$trs->transaction->id;
        } else if ($transaction instanceof AuthorisationTransaction && $transaction->step == 'PAID')
        {
            return "Authorisation bancaire n°".$trs->authorization->number;
        } else if ($transaction->step == 'REFUSED')
        {
            return "Echec de la transaction, raison: ".$trs->result->longMessage;
        }
    }
}