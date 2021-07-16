<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $table = 'medico';

    protected $fillable = ['description', 'direccion_consulta', 'cpm', 'rne', 'persona_id'];

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'persona_id', 'id');
    }

    //Un Medico tiene muchas especialidades
    // 1 -  N
    public function especialidad()
    {
        return $this->hasMany('App\Models\Especialidades', 'medico_id', 'id');
    }
}
