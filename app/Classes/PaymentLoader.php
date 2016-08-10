<?php

namespace App\Classes;

use App\Models\ImmediateTransaction;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Encryption\Encrypter;

#Facade
class PaymentLoader
{

    public function parseData($data)
    {
        if(!isset($data->type))
            throw new \Exception('Wrong payload form');

        switch ($data->type)
        {
            case 'checkout':
                $transaction = new ImmediateTransaction();
                $transaction->bind($data);
                break;
            case 'authorisation':
                //$this->type = 'authorisation';

                break;
            default:
                throw new \Exception('Wrong transaction type');
        }
        return $transaction;
    }

    public function load(Service $service, $payload)
    {
        $key = $service->api_key;

        $data = json_decode($this->decrypt($key, $payload));
        $transaction = $this->parseData($data);
        $transaction->service_id= $service->id;

        return $transaction;
    }

    public function decrypt($key, $payload)
    {
        $crypt = new Encrypter(base64_decode($key), 'AES-256-CBC');
        if($this->checkKey($key))
            return $crypt->decrypt($payload);
        else
            throw new \Exception('Cannot decrypt the payload');
    }

    public function encrypt($key, array $data)
    {
        $crypt = new Encrypter(base64_decode($key), 'AES-256-CBC');
        return base64_encode($crypt->encrypt(json_encode($data)));
    }

    protected function checkKey(string $key)
    {
        $crypt = new Encrypter(base64_decode($key), 'AES-256-CBC');
        return $crypt->supported(base64_decode($key), 'AES-256-CBC');
    }

}