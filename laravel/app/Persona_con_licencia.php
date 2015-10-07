<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona_con_licencia extends Model
{
    public $timestamps = false;
    protected $table = 'persona_con_licencia';
    protected $primaryKey = 'dni';
    protected $fillable = ['fecha_vencimiento'];

    public function persona(){
        return $this->hasOne('App\Persona', 'dni');
    }


}
