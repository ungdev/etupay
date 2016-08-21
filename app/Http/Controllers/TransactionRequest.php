<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Service;
use Illuminate\Http\Request;


class TransactionRequest extends Controller
{
    //
    public function testRequest(PaymentRequest $request)
    {
        $service = Service::find($request->input('service_id'));
        $paiment_request = new PaymentRequest();
        $paiment_request->setService($service);
        $paiment_request->setAmount(1000);
        $paiment_request->setDescription("Test de page");
        echo urlencode($paiment_request->getEncrypted());

    }

    public function incomming(PaymentRequest $request)
    {
         $request->Transaction->save();
        return redirect()->route('userFrontend.choose', $request->Transaction);
    }


}
