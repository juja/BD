<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cedula_vehicular extends Model
{
    public $timestamps = false;
    protected $table = 'cedula_vehicular';
    protected $primaryKey = 'codigo';

    public function registro_automotor(){
        return $this->hasMany('App\Registro_automotor','cedula_codigo','codigo');
    }

    //
}
