<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compania_seguro extends Model
{
    public $timestamps = false;
    protected $table = 'compania_seguro';

    public function vehiculos(){
        return $this->belongsToMany('App\Vehiculo','cobertura','compania_id','vehiculo_matricula');
    }

    public function tipo_cobertura(){
        return $this->belongsToMany('App\Tipo_cobertura','cobertura','compania_id','tipo_id');
    }


    //
}
