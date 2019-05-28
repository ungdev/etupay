<?php

namespace App\Http\Controllers;

use App\PaymentProvider\AtosProvider;
use App\PaymentProvider\PaylineProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        if ($request->input('notificationType') == 'WEBTRS' && $request->has('token')) {
            $provider->processCallback($request->input('token'));
        } else {
            $provider->processCallback($request->input('paylinetoken'));
        }

    }

}
