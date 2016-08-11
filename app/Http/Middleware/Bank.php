<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use App\Facades\PaymentRequest;
class Bank
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
        if(!$this->isIpAllowed())
            return response('Unauthorized.', 401);
        return $next($request);
    }
    
    private function isIpAllowed()
    {
        $ip = getRealUserIp();
        $ranges = explode(',', getenv('BANK_IP_RANGE'));
        foreach ($ranges as $range)
        {
            if($this->ip_in_range($ip, $range))
                return true;
        }

        return false;
    }

    private function ip_in_range( $ip, $range ) {
        if ( strpos( $range, '/' ) == false ) {
            $range .= '/32';
        }

        list( $range, $netmask ) = explode( '/', $range, 2 );
        $range_decimal = ip2long( $range );
        $ip_decimal = ip2long( $ip );
        $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
    }

    function getRealUserIp(){
        if($_SERVER['REMOTE_ADDR'] != '10.0.150.1')
            return $_SERVER['REMOTE_ADDR'];

        switch(true){
            case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default : return $_SERVER['REMOTE_ADDR'];
        }
    }
}
