<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TransactionScope implements Scope
{
    protected $type;

    public function __construct(string $type)
    {
        $this->type = strtoupper($type);
    }


    public function apply(Builder $builder, Model $model)
    {
        $builder->where('type', '=', $this->type);
        return $builder;
    }

}