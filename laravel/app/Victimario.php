<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Victimario extends Model
{
    public $timestamps = false;
    protected $table = 'victimario';

    public function persona(){
        return $this->belongsTo('App\Persona','dni','dni');
    }

    public function conclusion(){
        return $this->belongsTo('App\Conclusion','conclusion_id');
    }
    //
}
