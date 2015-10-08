<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Victima extends Model
{
    public $timestamps = false;
    protected $table = 'victima';

    public function persona(){
        return $this->belongsTo('App\Persona','dni','dni');
    }

    public function conclusion(){
        return $this->belongsTo('App\Conclusion','conclusion_id');
    }
    //
}
