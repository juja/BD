<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    public $timestamps = false;
    protected $table = 'localidad';

    public function provincia(){
        return $this->belongsTo('App\Provincia','provincia_id');
    }

    public function caminos(){
        return $this->belongsToMany('App\Camino','registro_calles');
    }
    //
}
