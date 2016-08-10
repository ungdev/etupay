<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function handleAtosCallback(Request $request)
    {

        Log::critical('Test');
    }
}
