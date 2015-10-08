<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_falla_humana extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_falla_humana';

    public function siniestros(){
        return $this->hasMany('App\Siniestro','id','tipo_falla_id');
    }
    //
}
