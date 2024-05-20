<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    use HasFactory;
    protected $table ='historias';
    protected $fillable = [
       'id_profesional',
       'informacion_relevante',
       'hora',
       'fecha',
       'consecutivo',
       'estado_paciente',
       'antecedentes',
       'evaluacion',
       'concepto',
       'recomendaciones',
       'estado',
       'id_paciente'
    ];
}
