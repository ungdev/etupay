<?php

namespace App\Http\Controllers;

use App\PaymentProvider\AtosProvider;
use App\PaymentProvider\PaypalProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function handleAtosCallback(Request $request)
    {
        //Log::critical(json_encode($request->all()));
        $provider = new AtosProvider();
        $provider->processCallback($request->input('DATA'));

    }

    public function handlePaypalCallback(Request $request)
    {
        $provider = new PaypalProvider();
        if($transaction = $provider->processCallback($request))
        {
            $payload = PaymentLoader::encryptFromService($transaction->service, $transaction->callbackReturn());
            return redirect($transaction->service->return_url.'?payload='.$payload);
        }

    }

    public function testCallback(Request $request)
    {
        Log::critical(json_encode($request->all()));
    }
}
