<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        return view('dashboard.services.list',[
            'services' => Auth::user()->getAdminServicesQuery()->with('transactions')->withCount('transactions')->get(),
        ]);
    }
}
