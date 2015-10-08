<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cedula_vehicular extends Model
{
    public $timestamps = false;
    protected $table = 'cedula_vehicular';
    protected $primaryKey = 'codigo';

    public function registro_automotor(){
        return $this->hasMany('App\Registro_automotor','cedula_codigo','codigo');
    }

    public function vehiculo_registro(){
        return $this->belongsToMany('App\Vehiculo','registro_automotor','codigo','matricula');
    }

    public function persona_registro(){
        return $this->belongsToMany('App\Persona','registro_automotor','codigo','dni');
    }

    //
}
