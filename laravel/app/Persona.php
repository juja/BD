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

    public function persona_con_licencia(){
        return $this->hasMany('App\Persona_con_licencia', 'dni','dni');
    }

    public function vehiculos(){
        return $this->hasMany('App\Vehiculo','dni','dni');
    }

    public function infracciones(){
        return $this->hasMany('App\Infraccion','dni','dni');
    }

    public function vehiculos_registro(){
        return $this->belongsToMany('App\Vehiculo','registro_automotor','dni','matricula');
    }

    public function cedulas_registro(){
        return $this->belongsToMany('App\Cedula_vehicular','registro_automotor','dni','cedula_codigo');
    }

    public function testigos(){
        return $this->hasMany('App\Testigos','dni','dni');
    }

    public function victimarios(){
        return $this->hasMany('App\Victimario','dni','dni');
    }

    public function victimas(){
        return $this->hasMany('App\Victima','dni','dni');
    }



    //
}