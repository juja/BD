<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_vehiculo extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_vehiculo';

    public function vehiculos(){
        return $this->hasMany('App\Vehiculo');
    }
    //
}
