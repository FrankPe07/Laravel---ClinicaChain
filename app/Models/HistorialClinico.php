<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    use HasFactory;

    protected $table = 'historial_clinico';

    protected $fillable = [
        'fecha',
        'motivo_consulta',
        'signo_sintomas',
        'diagnostico',
        'tratamiento',
        'cita_id'
    ];

    public $timestamps = false;
}
