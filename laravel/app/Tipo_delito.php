<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_delito extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_delito';

    public function antecedentes(){
        return $this->hasMany('App\Antecedente');
    }

}
