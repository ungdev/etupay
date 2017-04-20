<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        //Calcul CA
        $services_id = Auth::user()->getAdminServicesQuery()->get()->pluck('id');


        $total_ca = Transaction::query()
            ->whereIn('service_id', $services_id)
            ->where('provider','!=' ,'devMode')
            ->where('step', 'PAID')
            ->sum('amount');
        $total_ca /= 100;

        return view('home', compact('total_ca'));
    }
}