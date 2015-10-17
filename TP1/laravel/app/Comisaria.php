<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comisaria extends Model
{
    public $timestamps = false;
    protected $table = 'comisaria';
    protected $primaryKey = 'numero';
    public $incrementing = false;

    public function dir_altura(){
        return $this->belongsTo('App\Direccion','direccion_altura','altura');
    }

    public function dir_camino(){
        return $this->belongsTo('App\Direccion','direccion_camino_id','camino_id');
    }

    public function denuncias(){
        return $this->hasMany('App\Denuncia','comisaria_nro');
    }
    
    //
}
