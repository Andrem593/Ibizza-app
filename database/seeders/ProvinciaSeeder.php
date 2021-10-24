<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('provincias')->insert([
            [
                'descripcion' => 'AZUAY',
            ],
            [
                'descripcion' => 'BOLIVAR',
            ],
            [
                'descripcion' => 'CAÑAR',
            ],
            [
                'descripcion' => 'CARCHI',
            ],
            [
                'descripcion' => 'COTOPAXI',
            ],
            [
                'descripcion' => 'CHIMBORAZO',
            ],
            [
                'descripcion' => 'EL ORO',
            ],
            [
                'descripcion' => 'ESMERALDAS',
            ],
            [
                'descripcion' => 'GUAYAS',
            ],
            [
                'descripcion' => 'IMBABURA',
            ],
            [
                'descripcion' => 'LOJA',
            ],
            [
                'descripcion' => 'LOS RIOS',
            ],
            [
                'descripcion' => 'MANABI',
            ],
            [
                'descripcion' => 'MORONA SANTIAGO',
            ],
            [
                'descripcion' => 'NAPO',
            ],
            [
                'descripcion' => 'PASTAZA',
            ],
            [
                'descripcion' => 'PICHINCHA',
            ],
            [
                'descripcion' => 'TUNGURAHUA',
            ],
            [
                'descripcion' => 'ZAMORA CHINCHIPE',
            ],
            [
                'descripcion' => 'GALAPAGOS',
            ],
            [
                'descripcion' => 'SUCUMBIOS',
            ],
            [
                'descripcion' => 'ORELLANA',
            ],
            [
                'descripcion' => 'SANTO DOMINGO DE LOS TSACHILAS',
            ],
            [
                'descripcion' => 'SANTA ELENA',
            ],
        ]);
    }
}
