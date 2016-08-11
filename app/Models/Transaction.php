<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';


    public function callbackAccepted()
    {
        $this->step = 'PAID';
        $this->save();
    }

    public function callbackRefused()
    {
        $this->step = 'REFUSED';
        $this->save();
    }

    public function callbackCanceled()
    {
        $this->step = 'CANCELED';
        $this->save();
    }

    public function service()
    {
        return $this->hasOne('App\Service');
    }

    public function bind($data)
    {
        $data = (array) $data;
        $this->attributes['amount'] = $data['amount'];
        $this->attributes['description'] = (isset($data['description']) ? $data['description'] : null);
        $this->attributes['client_mail'] = (isset($data['client_mail']) ? $data['client_mail'] : null);
        $this->attributes['service_data'] = (isset($data['service_data']) ? $data['service_data'] : null);
    }

    public function getAtosParameter()
    {
        return [
            'customer_email' => $this->attributes['client_mail'],
            'capture_day' => $this->attributes['capture_day'],
            'caddie' => $this->attributes['id'],
        ];
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        switch ($attributes->type)
        {
            case 'PAYMENT':
                $model = new ImmediateTransaction;
                break;

            default:
                $model = $this->newInstance([], true);
        }

        $model->setRawAttributes((array) $attributes, true);

        $model->setConnection($connection ?: $this->connection);

        return $model;
    }


}
