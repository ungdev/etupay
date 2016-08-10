<?php

namespace App\Http\Middleware;

use App\Http\Requests\Request;
use App\Models\Service;
use Closure;
use Illuminate\Support\Facades\App;
use App\Facades\PaymentRequest;

class TransactionRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('payload') && $request->has('service_id'))
            if($this->checkService($request))
                return $next($request);

        return App::abort(401, 'Le service n\'a pas été identifié ');

    }

    protected function checkService($request)
    {
        $service = Service::findOrFail($request->input('service_id'));
        try
        {
            PaymentRequest::load($service, $request->input('payload'));

        } catch (\Exception $e)
        {
            return App::abort(401, 'Le service n\'a pas été identifié ');
        }

        return true;

    }
}
