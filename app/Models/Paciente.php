<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'paciente';

    protected $fillable = [
        'persona_id',
        'grupo_sanguineo',
        'num_historial',
        'familia_id',
        'parentesco_id'
    ];

    public $timestamps = false;


    // Relaciones con otras tablas
    public function Persona()
    {
        return $this->belongsTo('App\Models\Persona');
    }

    public function Parentesco()
    {
        return $this->belongsTo('App\Models\Parentesco', 'parentesco_id', 'id');
    }

    public function Paciente()
    {
        return $this->belongsTo('App\Models\Paciente', 'familia_id', 'id');
    }
}
