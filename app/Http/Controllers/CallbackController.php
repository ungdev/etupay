<?php

namespace App\Http\Controllers;

use App\PaymentProvider\AtosProvider;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function handleAtosCallback(Request $request)
    {
        Log::critical(json_encode($request->all()));
        $provider = new AtosProvider();
        $provider->processCallback($request->input('DATA'));
    }
}
