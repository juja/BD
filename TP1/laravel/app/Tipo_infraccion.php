<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_infraccion extends Model
{
    public $timestamps = false;
    protected $table = 'tipo_infraccion';

    public function infracciones(){
        return $this->hasMany('App\Infraccion');
    }
    //
}
