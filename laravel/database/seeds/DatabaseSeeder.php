<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TipoVehiculoTableSeeder::class);

        Model::reguard();
    }
}

class TipoCaminoTableSeeder extends Seeder {
    public function run(){
        DB::table('tipo_camino')->delete();

        $f = Faker\Factory::create('es_AR');

        $t = new App\Tipo();
        $t->nombre = "Total";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_cobertura();
        $t->nombre = "Terceros";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_cobertura();
        $t->nombre = "Tranqui";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_cobertura();
        $t->nombre = "120-loquedé";
        $t->descripcion = $f->realText(100,1);
        $t->save();
    }
}

class TipoCoberturaTableSeeder extends Seeder {
    public function run(){
        DB::table('tipo_cobertura')->delete();

        $f = Faker\Factory::create('es_AR');

        $t = new App\Tipo_cobertura();
        $t->nombre = "Total";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_cobertura();
        $t->nombre = "Terceros";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_cobertura();
        $t->nombre = "Tranqui";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_cobertura();
        $t->nombre = "120-loquedé";
        $t->descripcion = $f->realText(100,1);
        $t->save();
    }
}

class TipoDelitoTableSeeder extends Seeder {
    public function run(){
        DB::table('tipo_delito')->delete();

        $f = Faker\Factory::create('es_AR');

        $t = new App\Tipo_delito();
        $t->nombre = "Robo";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_delito();
        $t->nombre = "Hurto";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_delito();
        $t->nombre = "Asesinato";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_delito();
        $t->nombre = "Violacion";
        $t->descripcion = $f->realText(100,1);
        $t->save();
    }
}


class TipoFallaHumanaTableSeeder extends Seeder {
    public function run(){
        DB::table('tipo_falla_humana')->delete();

        $t = new App\Tipo_falla_humana();
        $t->nombre = "Alcoholizado";
        $t->descripcion = "Conducir bajo la influencia del alcohol";
        $t->save();

        $t = new App\Tipo_falla_humana();
        $t->nombre = "Drogado";
        $t->descripcion = "Conducir vehículo bajo influencia drogas o estupefacientes";
        $t->save();

        $t = new App\Tipo_falla_humana();
        $t->nombre = "Despistado";
        $t->descripcion = "No respetar señal Pare";
        $t->save();

        $t = new App\Tipo_falla_humana();
        $t->nombre = "Frenetico";
        $t->descripcion = "Conducir vehículo a mayor velocidad de la máxima legal permitida";
        $t->save();
    }
}

class TipoInfraccionTableSeeder extends Seeder {
    public function run(){
        DB::table('tipo_infraccion')->delete();

        $t = new App\Tipo_infraccion();
        $t->nombre = "Alcoholemia";
        $t->descripcion = "Conducir bajo la influencia del alcohol";
        $t->save();

        $t = new App\Tipo_infraccion();
        $t->nombre = "Drogas";
        $t->descripcion = "Conducir vehículo bajo influencia drogas o estupefacientes";
        $t->save();

        $t = new App\Tipo_infraccion();
        $t->nombre = "No respetar señal";
        $t->descripcion = "No respetar señal Pare";
        $t->save();

        $t = new App\Tipo_infraccion();
        $t->nombre = "Exceso velocidad";
        $t->descripcion = "CConducir vehículo a mayor velocidad de la máxima legal permitida";
        $t->save();
    }
}

class TipoPeritajeTableSeeder extends Seeder {
    public function run(){
        DB::table('tipo_peritaje')->delete();

        $t = new App\Tipo_peritaje();
        $t->nombre = "Suelo";
        $t->descripcion = "Investigacion del suelo";
        $t->save();

        $t = new App\Tipo_peritaje();
        $t->nombre = "Chequeo automovil";
        $t->descripcion = "Chequeo del automovil a fondo";
        $t->save();

        $t = new App\Tipo_peritaje();
        $t->nombre = "Alcoholemia";
        $t->descripcion = "Medicio de alcoholemia para los conductores";
        $t->save();

        $t = new App\Tipo_peritaje();
        $t->nombre = "Registro licencias";
        $t->descripcion = "Chequeo de que los papeles esten al dia";
        $t->save();
    }
}

class TipoVehiculoTableSeeder extends Seeder {
    public function run(){
        DB::table('tipo_vehiculo')->delete();

        $t = new App\Tipo_vehiculo();
        $t->nombre = "Auto";
        $t->save();

        $t = new App\Tipo_vehiculo();
        $t->nombre = "Camioneta";
        $t->save();

        $t = new App\Tipo_vehiculo();
        $t->nombre = "Camion";
        $t->save();

        $t = new App\Tipo_vehiculo();
        $t->nombre = "Motocicleta";
        $t->save();

        $t = new App\Tipo_vehiculo();
        $t->nombre = "Cuatriciclo";
        $t->save();
    }
}
