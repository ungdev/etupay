<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fundation extends Model
{
    public function services()
    {
        return $this->hasMany('App\Service');
    }
}
