<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    public $timestamps = false;
    protected $table = 'provincia';

    public function localidades(){
        return $this->hasMany('App\Localidad');
    }
    //
}
