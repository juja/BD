<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_accidente extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_accidente';

    public function siniestros(){
        return $this->hasMany('App\Siniestro');
    }
    //
}
