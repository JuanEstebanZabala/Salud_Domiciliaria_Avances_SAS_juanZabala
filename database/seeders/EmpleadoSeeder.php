<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empleado = Empleado::create([
            'name'=>'Juan Esteban',
            'email'=>'juan@gmail.com',
            'role'=>'Developer',
            'location'=>'Bucaramanga',
            'typography'=>'Arial',
            'avatar'=>''
    ]);
    }
}   