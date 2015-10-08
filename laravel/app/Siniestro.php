<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siniestro extends Model
{
    public $timestamps = false;
    protected $table = 'siniestro';

    public function testigos(){
        return $this->hasMany('App\Testigos');
    }

    public function conclusiones(){
        return $this->hasMany('App\Conclusion');
    }

    public function tipo_falla_humana(){
        return $this->belongsTo('App\Tipo_falla_huamana','tipo_falla_id');
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

    public function direccion_altura(){
        return $this->belongsTo('App\Direccion','direccion_altura','altura');
    }

    public function direccion_camino(){
        return $this->belongsTo('App\Direccion','direccion_camino_id','camino_id');
    }


    //
}
