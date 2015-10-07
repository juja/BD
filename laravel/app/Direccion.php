<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    public $timestamps = false;
    protected $table = 'direccion';
    protected $primaryKey = 'altura';

    public function infracciones_altura(){
        return $this->hasMany('App\Infraccion','altura','direccion_altura');
    }

    public function infracciones_camino(){
        return $this->hasMany('App\Infraccion','altura','direccion_altura');
    }
    //
}
