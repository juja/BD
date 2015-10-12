<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_camino extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_camino';

    public function caminos(){
        return $this->belongsToMany('App\Camino','clasificacion_camino','tipo_id','camino_id');
    }
    //
}
