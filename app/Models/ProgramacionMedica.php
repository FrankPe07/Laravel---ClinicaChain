<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramacionMedica extends Model
{
    use HasFactory;

    protected $table = 'programacion_medica';

    protected $fillable = ['calendario_id', 'medico_id'];

    public $timestamps = false;
}
