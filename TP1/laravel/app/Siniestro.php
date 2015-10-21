<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siniestro extends Model
{
    public $timestamps = false;
    protected $table = 'siniestro';

    public function testigos(){
        return $this->belongsToMany('App\Persona','testigos','siniestro_id','dni');
    }

    public function conclusiones(){
        return $this->hasMany('App\Conclusion');
    }

    public function tipoFallaHumana(){
        return $this->belongsTo('App\Tipo_falla_humana','tipo_falla_id');
    }

    public function tipo_accidente(){
        return $this->belongsTo('App\Tipo_accidente','tipo_accidente_id');
    }

    public function denuncia(){
        return $this->belongsTo('App\Denuncia');
    }

    public function colision(){
        return $this->belongsTo('App\Colision');
    }

    public function dir_altura(){
        return $this->belongsTo('App\Direccion','direccion_altura','altura');
    }

    public function dir_camino(){
        return $this->belongsTo('App\Direccion','direccion_camino_id','camino_id');
    }

    public function peritajes(){
        return $this->hasMany('App\Peritaje');
    }

    public function vehiculos_involucrados(){
        return $this->belongsToMany('App\Vehiculo','involucrados','siniestro_id','vehiculo_matricula');
    }


    //
}
