<?php

namespace Database\Seeders;

use App\Models\Ciudad;
use App\Models\Modelo;
use App\Models\Departamento;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Insertar departamentos
        $departamentoAntioquia = Departamento::create([
            'codigo' => '05',
            'nombre' => 'Antioquia'
        ]);

        $departamentoBogota = Departamento::create([
            'codigo' => '11',
            'nombre' => 'Bogotá D.C.'
        ]);
        
        $departamentoCali = Departamento::create([
            'codigo' => '76',
            'nombre' => 'Valle del Cauca'
        ]);

        //Insertar ciudades
        Ciudad::create([
            'departamento_id' => $departamentoAntioquia->id,
            'codigo' => '05001',
            'nombre' => 'Medellín'
        ]);

        Ciudad::create([
            'departamento_id' => $departamentoBogota->id,
            'codigo' => '11001',
            'nombre' => 'Bogotá'
        ]);

        Ciudad::create([
            'departamento_id' => $departamentoCali->id,
            'codigo' => '76001',
            'nombre' => 'Cali'
        ]);

        Ciudad::create([
            'departamento_id' => $departamentoCali->id,
            'codigo' => '76520',
            'nombre' => 'Palmira'
        ]);

        Ciudad::create([
            'departamento_id' => $departamentoCali->id,
            'codigo' => '76892',
            'nombre' => 'Yumbo'
        ]);

        //Insertar modelos
        Modelo::create([
            'nombre' => 'Rexton G4'
        ]);

        Modelo::create([
            'nombre' => 'Tivoli'
        ]);

        Modelo::create([
            'nombre' => 'Korando'
        ]);

        Modelo::create([
            'nombre' => 'Rexton Sports'
        ]);

        Modelo::create([
            'nombre' => 'XLV'
        ]);
    }
}
