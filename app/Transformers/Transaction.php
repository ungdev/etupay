<?php

namespace App\Transformers;

use App\Models\Transaction;
use Flugg\Responder\Transformers\Transformer;

class TransactionTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id' => (int) $transaction->id,
        ];
    }
}
