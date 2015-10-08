<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testigos extends Model
{
    public $timestamps = false;
    protected $table = 'testigos';

    public function siniestro(){
        return $this->belongsTo('App\Siniestro','siniestro_id');
    }

    public function persona(){
        return $this->belongsTo('App\Persona','dni','dni');
    }
    //
}
