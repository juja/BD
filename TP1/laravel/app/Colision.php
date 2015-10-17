<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colision extends Model
{
    public $timestamps = false;
    protected $table = 'colision';

    public function siniestro(){
        return $this->hasMany('App\Siniestro');
    }

}
