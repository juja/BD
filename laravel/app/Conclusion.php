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
        return $this->hasMany('App\Victima');
    }

    public function victimario(){
        return $this->hasMany('App\Victimario');
    }
    //
}
