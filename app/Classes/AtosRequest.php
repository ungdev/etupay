<?php

namespace App\Classes;

use App\Classes\AtosResponse;
use Illuminate\Support\Facades\Config;

class AtosRequest
{
    const API_VERSION = '6.15';
    const DEFAULT_CURRENCY_CODE = '978';
    private $currencies = array(
        'EUR' => '978',         // Euro
        'USD' => '840',         // US Dollar
        'CHF' => '756',         // Swiss Franc
        'GBP' => '826',         // Pound Sterling
        'CAD' => '124',         // Canadian Dollar
        'JPY' => '392',         // Yen
        'MXN' => '484',         // Mexican Peso
        'TRY' => '949',         // Yeni Türk Liras
        'AUD' => '036',         // Australian Dollar
        'NZD' => '554',         // New Zealand Dollar
        'NOK' => '578',         // Norwegian Krone
        'BRL' => '986',         // Brazilian Real
        'ARS' => '032',         // Argentine Peso
        'KHR' => '116',         // Riel
        'TWD' => '901',         // New Taiwan Dollar
        'SEK' => '752',         // Swedish Krona
        'DKK' => '208',         // Danish Krone
        'KRW' => '410',         // Won
        'SGD' => '702',         // Singapore Dollar
        'XPF' => '953',         // CFP Franc
        'XOF' => '952',         // CFA Franc BCEAO
    );
    protected $merchantId;      // Merchant ID assigned by SIPS
    protected $country;         // Merchant country code ISO 3166
    protected $pathfile;        // Path of the configuration file
    protected $requestPath;     // Path of the request binary from the SIPS API
    protected $responsePath;    // Path of the response binary from the SPIS API
    protected $isDebug;         // Debug mode (SIPS test environment)
    public function __construct($merchantId, $country, $pathfile, $requestPath, $responsePath, $isDebug)
    {
        $this->merchantId   = $merchantId;
        $this->country      = $country;
        $this->pathfile     = $pathfile;
        $this->requestPath  = $requestPath;
        $this->responsePath = $responsePath;
        $this->isDebug      = !!$isDebug;
    }
    /**
     * Get the SIPS checkout buttons
     *
     * @param float $amount
     * @param string $currency
     * @param array $config
     * @param array $parameters
     * @return App\Classes\AtosResponse
     */
    public function requestGetCheckoutToken($amount, $currency, array $parameters = array())
    {
        return $this->sendApiRequest($this->requestPath, array_merge($parameters, array(
            "merchant_id"       => $this->merchantId,
            "merchant_country"  => $this->country,
            "pathfile"          => $this->pathfile,
            "amount"            => $amount,
            "currency_code"     => $this->getCurrencyCode($currency),
            "automatic_response_url" => Config::get('payment.atos.callback_url'),
            "cancel_return_url" => Config::get('payment.atos.cancel_url'),
            "normal_return_url" => Config::get('payment.atos.return_url'),
        )));
    }
    /**
     * Do SIPS checkout payment
     *
     * @param array $config
     * @param string $encryptedData
     * @return App\Classes\AtosResponse
     */
    public function requestDoCheckoutPayment($encryptedData)
    {
        return $this->sendApiRequest($this->responsePath, array(
            "pathfile"  => $this->pathfile,
            "message"   => $encryptedData
        ));
    }
    /**
     * Send the request to the Sips API
     *
     * @param string $action
     * @return array $parameters
     */
    protected function sendApiRequest($action, array $parameters)
    {
        // Call the SIPS API
        $result = exec($action.' '.$this->encodeArray($parameters));
        $response = new AtosResponse(explode('!', $result));
        if ($response->isError()) {
            throw new \Exception('The API request was not successful (Status: '.$response->getError().')');
        }
        return $response;
    }
    public function getCallPaymentUrl()
    {
        return $this->isDebug ? 'https://payment.sips-atos.com:443/cgis-payment/demo/callpayment' : 'https://payment.sips-atos.com:443/cgis-payment/prod/callpayment';
    }
    /**
     * Convert amounts from the SIPS format
     *
     * @param string $amount
     * @param string $currency
     * @return float
     */
    public function convertAmountFromSipsFormat($amount, $currency)
    {
        switch ($currency) {
            case '392':     // Yen
            case '410':     // Won
            case '953':     // CFP Franc
            case '952':     // CFA Franc BCEAO
                return $amount;
                break;
            default:
                return $amount / 100;
                break;
        }
    }
    /**
     * Convert amounts in the format waited by SIPS
     *
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public function convertAmountToSipsFormat($amount, $currency)
    {
        switch ($currency) {
            case 'JPY':     // Yen
            case 'KRW':     // Won
            case 'XPF':     // CFP Franc
            case 'XOF':     // CFA Franc BCEAO
                return number_format($amount, 0, '.', '');
                break;
            default:
                return number_format($amount * 100, 0, '.', '');
                break;
        }
    }
    /**
     * Get the currency code
     *
     * @param string $currency
     * @return string
     */
    protected function getCurrencyCode($currency)
    {
        $code = self::DEFAULT_CURRENCY_CODE;
        if (array_key_exists($currency, $this->currencies)) {
            $code = $this->currencies[$currency];
        }
        return $code;
    }
    /**
     * Encode an array into shell parameters
     *
     * @param array $encode
     * @return string
     */
    protected function encodeArray(array $encode)
    {
        $encoded = '';
        foreach ($encode as $name => $value) {
            $encoded .= ' '.$name.'='.escapeshellarg($value);
        }
        return substr($encoded, 1);
    }
}