<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEspecialidad extends Model
{
    use HasFactory;

    protected $table = 'tipo_especialidad';

    protected $fillable = ['Especialidad', 'Descripcion'];
}
