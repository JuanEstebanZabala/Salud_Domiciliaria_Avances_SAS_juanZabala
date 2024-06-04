<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
     use HasFactory;
    protected $table ='Empleados';
    protected $fillable = [
       'name',
       'email',
       'role',
       'location',
       'typography',
       'avatar'

    ];
}
