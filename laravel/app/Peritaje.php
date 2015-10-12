<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peritaje extends Model
{
    public $timestamps = false;
    protected $table = 'peritaje';

    public function tipo_peritaje(){
        return $this->belongsTo('App\Tipo_peritaje');
    }

    public function siniestro(){
        return $this->belongsTo('App\Siniestro');
    }
    //
}
