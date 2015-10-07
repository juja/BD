<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comisaria extends Model
{
    public $timestamps = false;
    protected $table = 'colision';
    protected $primaryKey = 'numero';

    public function direccion_altura(){
        return $this->belongsTo('App\Direccion','altura','direccion_altura');
    }

    public function direccion_camino(){
        return $this->belongsTo('App\Direccion','camino_id','direccion_camino_id');
    }

    public function denuncias(){
        return $this->hasMany('App\Denuncia','comisaria_nro');
    }
    
    //
}
