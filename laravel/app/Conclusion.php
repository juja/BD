<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conclusion extends Model
{
    public $timestamps = false;
    protected $table = 'conclusion';

    public function siniestro(){
        return $this->belongsTo('App\Siniestro');
    }

    public function victima(){
        return $this->belongsToMany('App\Persona','victima','conclusion_id','dni');
    }

    public function victimario(){
        return $this->belongsToMany('App\Persona','victimario','conclusion_id','dni');
    }
    //
}
