<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';

    protected $fillable = [
        'nombre',
        'apellidos',
        'genero',
        'domicilio',
        'dni',
        'ocupacion',
        'lugar_nacimiento',
        'fecha_nacimiento',
        'estado_civil',
        'imagen',
        'estado',
    ];

    public function user()
    {
        return $this->hasOne( 'App\Models\User' );
    }
    public function paciente()
    {
        return $this->hasOne('App\Models\Paciente');
    }
    public function medico()
    {
        return $this->hasOne('App\Models\Medico');
    }
}
