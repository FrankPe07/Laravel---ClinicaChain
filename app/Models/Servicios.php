<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'tipo_servicio_id',
        'descripcion',
        'precio',
        'medico_id',
    ];

    public $timestamps = false;


    public function tipo_servicio()
    {
        return $this->hasOne('App\Models\TipoServicio', 'id', 'tipo_servicio_id');
    }
}
