<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria_vehiculo extends Model
{
    public $timestamps = false;
    protected $table = 'categoria_vehiculo';

    public function vehiculos(){
        return $this->hasMany('App\Vehiculo');
    }
}
