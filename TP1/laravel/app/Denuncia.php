<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    public $timestamps = false;
    protected $table = 'denuncia';

    public function comisaria(){
        return $this->belongsTo('App\Comisaria','comisaria_nro','numero');
    }

    public function siniestro(){
        return $this->hasMany('App\Siniestro');
    }
    //
}
