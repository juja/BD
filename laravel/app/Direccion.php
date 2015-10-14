<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    public $timestamps = false;
    protected $table = 'direccion';
    protected $primaryKey = 'altura';
    public $incrementing = false;

    public function infracciones_altura(){
        return $this->hasMany('App\Infraccion','altura','direccion_altura');
    }

    public function infracciones_camino(){
        return $this->hasMany('App\Infraccion','camino_id','direccion_camino_id');
    }

    public function siniestro_altura(){
        return $this->hasMany('App\Siniestro','altura','direccion_altura');
    }

    public function siniestro_camino(){
        return $this->hasMany('App\Siniestro','camino_id','direccion_camino_id');
    }

    public function comisaria_altura(){
        return $this->hasMany('App\Comisaria','altura','direccion_altura');
    }

    public function comisaria_camino(){
        return $this->hasMany('App\Comisaria','camino_id','direccion_camino_id');
    }

    public function camino(){
        return $this->belongsTo('App\Camino','camino_id');
    }

    public function esquina(){
        return $this->belongsTo('App\Camino','esquina_camino_id');
    }


    //
}
