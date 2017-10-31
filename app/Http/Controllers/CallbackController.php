<?php

namespace App\Http\Controllers;

use App\PaymentProvider\AtosProvider;
use App\PaymentProvider\PaylineProvider;
use App\PaymentProvider\PaypalProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Facades\PaymentLoader;

class CallbackController extends Controller
{
    public function handleAtosCallback(Request $request)
    {
        $provider = new AtosProvider();
        $provider->processCallback($request->input('DATA'));

    }

    public function handlePaypalCallback(Request $request)
    {

    }

    public function handlePaylineCallback(Request $request)
    {
        $provider = new PaylineProvider();
        Log::info('Payline callback');
        $provider->processCallback($request->input('token'));

    }

}
