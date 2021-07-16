<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    protected $table = 'resena';

    protected $fillable = ['cita_id', 'calificacion', 'opinion'];

    public $timestamps = false;
}