<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_cobertura extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_cobertura';

    public function companias(){
        return $this->belongsToMany('App\Compania_seguro','cobertura','tipo_id','compania_id');
    }

    public function vehiculos(){
        return $this->belongsToMany('App\Vehiculo','cobertura','tipo_id','vehiculo_matricula');
    }

}
