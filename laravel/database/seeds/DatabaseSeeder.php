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

        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(TipoVehiculoTableSeeder::class);
        $this->call(TipoPeritajeTableSeeder::class);
        $this->call(TipoInfraccionTableSeeder::class);
        $this->call(TipoFallaHumanaTableSeeder::class);
        $this->call(TipoDelitoTableSeeder::class);
        $this->call(TipoCoberturaTableSeeder::class);
        $this->call(TipoCaminoTableSeeder::class);
        $this->call(TipoAccidenteTableSeeder::class);
        $this->call(ProvinciaTableSeeder::class);
        $this->call(PersonaCLTableSeeder::class);
        $this->call(LocalidadTableSeeder::class);
        $this->call(CompaniaSeguroTableSeeder::class);
        $this->call(CaminoTableSeeder::class);
        $this->call(ComisariaTableSeeder::class);
        $this->call(ColisionTableSeeder::class);
        $this->call(CategoriaVehiculoTableSeeder::class);
        $this->call(AntecedenteVehiculoTableSeeder::class);
        $this->call(VehiculoInfraccionTableSeeder::class);
        $this->call(SiniestroTableSeeder::class);

        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Model::reguard();
    }
}

class SiniestroTableSeeder extends Seeder {
    public function run(){
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('siniestro')->delete();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $f = Faker\Factory::create('es_AR');
        for($i=0;$i<40;$i++) {

            $s = new App\Siniestro();
            $s->descripcion = $f->text;
            $s->fecha_hora = $f->dateTimeThisYear;
            $s->tipoFallaHumana()->associate(App\Tipo_falla_humana::orderByRaw("RAND()")->first());
            $s->tipo_accidente()->associate(App\Tipo_accidente::orderByRaw("RAND()")->first());

            //Creo la denuncia
            $de = new App\Denuncia();
            $de->fecha = $f->dateTimeBetween($s->fecha_hora, '1 years');
            $de->comisaria(App\Comisaria::orderByRaw("RAND()")->first());
            $de->save();
            //Fin denuncia

            $s->denuncia()->associate($de);
            $s->colision()->associate(App\Colision::orderByRaw("RAND()")->first());

            //Creo direccion
            $d = new App\Direccion;
            $c = App\Camino::orderByRaw("RAND()")->take(2)->get();
            $d->altura = $f->numberBetween(0, $c[0]->longitud);
            $d->camino()->associate($c[0]);
            $d->esquina()->associate($c[1]);
            $d->save();
            //Fin direccion

            $s->dir_altura()->associate($d);
            $s->dir_camino()->associate($d);
            $s->save(); //Asi me genero el id.

            //Creo peritajes
            for ($j=0; $j<4; $j++) {
                $p = new App\Peritaje();
                $p->fecha = $f->dateTimeBetween($s->fecha_hora, '1 years');
                $p->descripcion = $f->text;
                $p->conclusion = $f->text;
                $p->tipo_peritaje()->associate(App\Tipo_peritaje::orderByRaw("RAND()")->first());
                $p->siniestro()->associate($s);
                $p->save();
            } //Fin peritajes

            //Las primeras 4 son testigos, el 5to es la victima y el 6to el victimario.
            $ps = App\Persona::orderByRaw("RAND()")->take(6)->get();
            $s->testigos()->attach($ps[0]);
            $s->testigos()->attach($ps[1]);
            $s->testigos()->attach($ps[2]);
            $s->testigos()->attach($ps[3]);

            $inv = new App\Involucrados();
            $inv->siniestro_id = $s->id;
            $inv->vehiculo_matricula = $ps[4]->vehiculos[0]->matricula;
            $inv->persona_dni = $ps[4]->dni;
            $inv->save();

            $inv = new App\Involucrados();
            $inv->siniestro_id = $s->id;
            $inv->vehiculo_matricula = $ps[5]->vehiculos[0]->matricula;
            $inv->persona_dni = $ps[5]->dni;
            $inv->save();

            $co = new App\Conclusion();
            $co->conclusion_final = $f->text;
            $co->siniestro()->associate($s);
            $co->save();

            $co->victima()->attach($ps[4]);
            $co->victimario()->attach($ps[5]);

            $s->save();

        }
    }
}

class VehiculoInfraccionTableSeeder extends Seeder {
    public function run() {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('cedula_vehicular')->delete();
        //DB::table('registro_automotor')->delete();
        //DB::table('cobertura')->delete();
        //DB::table('infraccion')->delete();
        //DB::table('vehiculo')->delete();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $personas = App\Persona::all();
        $f = Faker\Factory::create('es_AR');

        //Asigno dueños
        foreach($personas as $p) {
            $v = new App\Vehiculo();
            $v->matricula = $f->bothify('???###');
            $v->modelo = $f->year;
            $v->detalle = $f->text;
            $v->tipo()->associate(App\Tipo_vehiculo::orderByRaw("RAND()")->first());
            $v->dueno()->associate($p);
            $v->categoria()->associate(App\Categoria_vehiculo::orderByRaw("RAND()")->first());
            $v->save();

            $c = new App\Cedula_vehicular();
            $c->codigo = $f->unique()->numberBetween(0, 10000);
            $c->tipo_cedula = rand(0,1) == 0 ? 'Verde' : 'Azul';
            $c->save();

            $r = new App\Registro_automotor();
            $r->dni = $p->dni;
            $r->matricula = $v->matricula;
            $r->cedula_codigo = $c->codigo;
            $r->save();

            if (rand(0,1)) {
                $i = new App\Infraccion;
                $i->descripcion = $f->text;
                $i->fecha = $f->dateTimeThisYear;
                $v->dueno;
                $i->persona()->associate($v->dueno);
                $i->vehiculo()->associate($v);
                $d = new App\Direccion;
                $c = App\Camino::orderByRaw("RAND()")->take(2)->get();
                $d->altura = $f->numberBetween(0, $c[0]->longitud);
                $d->camino()->associate($c[0]);
                $d->esquina()->associate($c[1]);
                $d->save();
                $i->dir_altura()->associate($d);
                $i->dir_camino()->associate($d);
                $i->save();
            }

            $tc = App\Tipo_cobertura::orderByRaw("RAND()")->first();
            $co = App\Compania_seguro::orderByRaw("RAND()")->first();
            $cc = new App\Cobertura();
            $cc->vehiculo_matricula = $v->matricula;
            $cc->tipo_id = $tc->id;
            $cc->compania_id = $co->id;
            $cc->save();

            $v->save();
        }

    }
}

class AntecedenteVehiculoTableSeeder extends Seeder {
    public function run() {
        //DB::table('antecedente')->delete();
        $personas = App\Persona::all();
        $f = Faker\Factory::create('es_AR');

        foreach($personas as $p) {
            $a = new App\Antecedente();
            $a->fecha = $f->dateTimeThisYear;
            $a->descripcion = $f->realText(100,1);
            $a->persona()->associate($p);
            $a->tipo_delito()->associate(App\Tipo_delito::orderByRaw("RAND()")->first());
            $a->save();
        }
    }
}

class CategoriaVehiculoTableSeeder extends Seeder {
    public function run() {

        //DB::table('categoria_vehiculo')->delete();

        $c = new App\Categoria_vehiculo();
        $c->nombre = "ALTA GAMA";
        $c->save();

        $c = new App\Categoria_vehiculo();
        $c->nombre = "GAMA MEDIA";
        $c->save();

        $c = new App\Categoria_vehiculo();
        $c->nombre = "UTILITARIO";
        $c->save();
    }
}

class ColisionTableSeeder extends Seeder {
    public function run() {

        //DB::table('colision')->delete();
        $c = new App\Colision;
        $c->descripcion = "COLISIÓN FRONTAL";
        $c->save();

        $c = new App\Colision;
        $c->descripcion = "COLISIÓN POR ALCANCE";
        $c->save();

        $c = new App\Colision;
        $c->descripcion = "COLISIÓN FRONTOLATERAL O EMBESTIDA";
        $c->save();

        $c = new App\Colision;
        $c->descripcion = "COLISION POR ROCES";
        $c->save();

        $c = new App\Colision;
        $c->descripcion = "COLISIONES MIXTAS";
        $c->save();

        $c = new App\Colision;
        $c->descripcion = "ACCIDENTES MIXTOS";
        $c->save();

    }
}

class ComisariaTableSeeder extends Seeder {
    public function run() {

        //DB::table('comisaria')->delete();
        $f = Faker\Factory::create('es_AR');

        for($i=0;$i<10;$i++) {
            $c = App\Camino::orderByRaw("RAND()")->take(2)->get();

            $d = new App\Direccion();
            $d->altura = $f->numberBetween(0,$c[0]->longitud);
            $d->camino()->associate($c[0]);
            $d->esquina()->associate($c[1]);
            $d->save();


            $co = new App\Comisaria();
            $co->numero = $i;
            $co->dir_camino()->associate($d);
            $co->dir_altura()->associate($d);
            $co->save();
        }
    }
}

class CaminoTableSeeder extends Seeder {
    public function run() {
        //DB::table('camino')->delete();

        $f = Faker\Factory::create('es_AR');
        $ls = App\Localidad::all();
        foreach ($ls as $i => $l) {
            for($i=0; $i<20;$i++) {
                $c = new App\Camino;
                $c->nombre = $f->streetName;
                $c->longitud = $f->numerify('##00');
                $c->save();
                $c->localidades()->save($l,['altura_desde' => 0,'altura_hasta' => $c->longitud]);

                $t = App\Tipo_camino::orderByRaw("RAND()")->first();
                $c->tipos_caminos()->save($t,['altura_desde' => 0,'altura_hasta' => $c->longitud, 'longitud' => $c->longitud]);

                $c->save();
            }
        }
    }
}


class CompaniaSeguroTableSeeder extends Seeder {
    public function run() {

        //DB::table('compania_seguro')->delete();
        $f = Faker\Factory::create('es_AR');
        for($i=0;$i<20;$i++) {
            $c = new App\Compania_seguro();
            $c->nombre = $f->company;
            $c->descripcion = $f->realText(100,1);
            $c->save();
        }
    }
}

class LocalidadTableSeeder extends Seeder
{
    public function run()
    {

        //DB::table('localidad')->delete();
        $f = Faker\Factory::create('es_AR');
        $ps = App\Provincia::all();
        foreach ($ps as $p) {
            for($i=0; $i<50;$i++) {
                $l = new App\Localidad;
                $l->nombre = $f->city;
                $l->provincia()->associate($p);
                $l->save();
            }
        }
    }
}

class PersonaCLTableSeeder extends Seeder {
    public function run(){

        //DB::table('persona_con_licencia')->delete();

        //DB::table('persona')->delete();
        $f = Faker\Factory::create('es_AR');
        for($i=0; $i<100; $i++) {
            $p = new App\Persona;
            $p->dni = $f->unique()->randomNumber(8);
            $p->nombre = $f->firstName;
            $p->apellido = $f->lastName;
            $p->nacionalidad = $f->country;
            $p->save();
            if ($i<=80) {
                $pc = new App\Persona_con_licencia();
                $pc->fecha_vencimiento = $f->dateTimeThisYear;
                $pc->persona()->associate($p);
                $pc->save();
            }
        }
    }
}


class ProvinciaTableSeeder extends Seeder {
    public function run(){

        //DB::table('provincia')->delete();
        $data = array('CABA','BUENOS AIRES','CATAMARCA','CORDOBA','CORRIENTES','CHACO','CHUBUT','ENTRE RIOS','FORMOSA','JUJUY','LA PAMPA','LA RIOJA','MENDOZA','MISIONES','NEUQUEN','RIO NEGRO','SALTA','SAN JUAN','SAN LUIS','SANTA CRUZ','SANTA FE','SANTIAGO DEL ESTERO','TUCUMAN','TIERRA DEL FUEGO');
        foreach($data as $prov) {
            $p = new App\Provincia;
            $p->nombre = $prov;
            $p->save();
        }
    }
}

class TipoAccidenteTableSeeder extends Seeder {
    public function run(){

        //DB::table('tipo_accidente')->delete();

        $f = Faker\Factory::create('es_AR');

        $t = new App\Tipo_accidente();
        $t->nombre = "Choque";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_accidente();
        $t->nombre = "Atropello";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_accidente();
        $t->nombre = "Descarrilado";
        $t->descripcion = $f->realText(100,1);
        $t->save();

        $t = new App\Tipo_accidente();
        $t->nombre = "Incendio";
        $t->descripcion = $f->realText(100,1);
        $t->save();
    }
}



class TipoCaminoTableSeeder extends Seeder {
    public function run(){

        //DB::table('tipo_camino')->delete();

        $f = Faker\Factory::create('es_AR');

        $t = new App\Tipo_camino();
        $t->nombre = "Pavimento";
        $t->save();

        $t = new App\Tipo_camino();
        $t->nombre = "Ripio";
        $t->save();

        $t = new App\Tipo_camino();
        $t->nombre = "Tierra";
        $t->save();

        $t = new App\Tipo_camino();
        $t->nombre = "Madera";
        $t->save();
    }
}

class TipoCoberturaTableSeeder extends Seeder {
    public function run(){

        //DB::table('tipo_cobertura')->delete();

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

        //DB::table('tipo_delito')->delete();

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

        //DB::table('tipo_falla_humana')->delete();

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

        //DB::table('tipo_infraccion')->delete();

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

        //DB::table('tipo_peritaje')->delete();

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

        //DB::table('tipo_vehiculo')->delete();
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
