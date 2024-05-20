<?php

namespace Database\Seeders;

use App\Models\Historia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historia1 = Historia::create([
        'id_profesional' => '2', 
        'informacion_relevante' =>  'estado somnoliento por receta de pastillas', 
        'hora' => '22:00:00', 
        'fecha' => '22/05/17', 
        'consecutivo' => '1', 
        'estado' => 'pendiente',
        'antecedentes'=>'padres con problemas cardiacos',
        'evaluacion'=>'cambio de recetas',
        'concepto'=>'',
        'recomendaciones'=>'',
        'id_paciente'=>'3'
    ]);
    }
}     