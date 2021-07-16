<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
    use HasFactory;

    protected $table = 'especialidad';

    protected $fillable = ['tipo_especialidad_id', 'medico_id'];

    public $timestamps = false;

    public function medico()
    {
        return $this->hasOne('App\Models\Medico', 'id', 'medico_id');
    }

    public function tipoEspecialidad()
    {
        return $this->hasOne('App\Models\TipoEspecialidad' ,'id', 'tipo_especialidad_id');
    }
}
