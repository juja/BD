<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona_con_licencia extends Model
{
    public $timestamps = false;
    protected $table = 'persona_con_licencia';

    public function persona(){
        return $this->belongsTo('App\Persona', 'dni','dni');
    }


}
