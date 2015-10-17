<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    public $timestamps = false;
    protected $table = 'antecedente';

    public function tipo_delito() {
        return $this->belongsTo('App\Tipo_delito');
    }

    public function persona(){
        return $this->belongsTo('App\Persona','dni','dni');
    }

}
