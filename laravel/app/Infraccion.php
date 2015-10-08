<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infraccion extends Model
{
    public $timestamps = false;
    protected $table = 'infraccion';

    public function direccion_altura(){
        return $this->belongsTo('App\Direccion','direccion_altura','altura');
    }

    public function direccion_camino(){
        return $this->belongsTo('App\Direccion','direccion_camino_id','camino_id');
    }

    public function vehiculo(){
        return $this->belongsTo('App\Vehiculo','vehiculo_matricula','matricula');
    }

    public function persona(){
        return $this->belongsTo('App\Persona','dni','dni');
    }

    //
}
