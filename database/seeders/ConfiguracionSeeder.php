<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run()
    {
        Configuracion::create([
            'clave_original' => '9*2z2n5mo$PIDR+P&b&V',
            'cod_empresa' => '0081',
            'cod_servicio' => '1001',
        ]);
    }
}
