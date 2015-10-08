<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_camino extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_camino';

    public function siniestros(){
        return $this->hasMany('App\Siniestro');
    }
    //
}
