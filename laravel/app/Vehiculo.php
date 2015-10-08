<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    public $timestamps = false;
    protected $table = 'vehiculo';
    protected $primaryKey = 'matricula';

    public function persona(){
        return $this->belongsTo('App\Persona','dni','dni');
    }

    public function tipo(){
        return $this->belongsTo('App\Tipo_vehiculo','tipo_id');
    }

    public function categoria(){
        return $this->belongsTo('App\Categoria_vehiculo');
    }

    public function compania_seguro(){
        return $this->belongsToMany('App\Compania_seguro','cobertura','vehiculo_matricula','compania_id');
    }

    public function tipo_cobertura(){
        return $this->belongsToMany('App\Tipo_cobertura','cobertura','vehiculo_matricula','tipo_id');
    }

    public function personas_registro(){
        return $this->belongsToMany('App\Persona','registro_automotor','matricula','dni');
    }

    public function cedulas_registro(){
        return $this->belongsToMany('App\Cedula_vehicular','registro_automotor','matricula','cedula_codigo');
    }

    public function infracciones(){
        return $this->hasMany('App\Infraccion','matricula','vehiculo_matricula');
    }




    //
}
