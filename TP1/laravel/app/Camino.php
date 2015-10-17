<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camino extends Model
{
    public $timestamps = false;
    protected $table = 'camino';

    public function tipos_caminos(){
        return $this->belongsToMany('App\Tipo_camino','clasificacion_camino','camino_id','tipo_id');
    }

    public function direcciones(){
        return $this->hasMany('App\Direccion');
    }

    public function localidades(){
        return $this->belongsToMany('App\Localidad','registro_calles')->withPivot(['altura_desde','altura_hasta']);
    }


    //
}
