<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_peritaje extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_peritaje';

    public function peritajes(){
        return $this->hasMany('App\Peritaje');
    }
    //
}
