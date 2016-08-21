<?php

namespace App\Models;

use App\Jobs\TransactionNotify;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $type = 'default';

    public function callbackAccepted()
    {
        $this->step = 'PAID';
        $this->save();

        dispatch(new TransactionNotify($this));
    }

    public function callbackRefused()
    {
        $this->step = 'REFUSED';
        $this->save();

        dispatch(new TransactionNotify($this));
    }

    public function callbackCanceled()
    {
        $this->step = 'CANCELED';
        $this->save();

        dispatch(new TransactionNotify($this));
    }

    public function service()
    {
        return $this->hasOne('App\Models\Service', 'id', 'service_id');
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

    public function callbackReturn()
    {
        return [
            'transaction_id' => $this->id,
            'type' => $this->getType(),
            'amount' => $this->amount,
            'service_data' => $this->service_data,
            'step' => $this->step,
        ];
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        switch ($attributes->type)
        {
            case 'PAYMENT':
                $model = new ImmediateTransaction([], true);
                break;

            default:
                $model = $this->newInstance([], true);
        }

        $model->setRawAttributes((array) $attributes, true);

        $model->setConnection($connection ?: $this->connection);

        $model->checkExistence();
        return $model;
    }

    public function getType()
    {
        return $this->type;
    }
    public function checkExistence()
    {
        if($this->attributes['id'])
            $this->exists = true;
    }


}
