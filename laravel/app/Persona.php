<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public $timestamps = false;
    protected $table = 'persona';
    protected $primaryKey = 'dni';

    public function antecedentes(){
        return $this->hasMany('App\Antecedente', 'dni');
    }

    public function con_licencia()
    {
        return $this->hasOne('App\Persona_con_licencia', 'dni');
    }

    public function vehiculos(){
        return $this->hasMany('App\Vehiculo');
    }

    //
}