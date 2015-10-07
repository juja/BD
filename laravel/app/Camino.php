<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camino extends Model
{
    public $timestamps = false;
    protected $table = 'camino';

    public function clasificacion_camino(){
        return $this->hasMany('App\Clasificacion_camino');
    }

    public function clasificacion_camino(){
        return $this->hasMany('App\Registro_calles');
    }

    public function clasificacion_camino(){
        return $this->hasMany('App\Direccion');
    }

    //
}
