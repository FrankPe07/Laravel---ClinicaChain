<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'cita';

    protected $fillable = ['medico_id', 'paciente_id', 'programacion_id', 'especialidad_id', 'descripcion_cita', 'condicion'];

    public $timestamps = false;
}
