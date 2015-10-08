<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro_automotor extends Model
{
    public $timestamps = false;
    protected $table = 'registro_automotor';

    public function persona(){
        return $this->belongsTo('App\Persona','dni','dni');
    }

    public function vehiculo(){
        return $this->belongsTo('App\Vehiculo','matricula','matricula');
    }

    public function cedula(){
        return $this->belongsTo('App\Cedula_vehicular','cedula_codigo','codigo');
    }

    //
}
