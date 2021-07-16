<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horas extends Model
{
    use HasFactory;

    protected $table = 'horas';

    protected $fillable = ['hora_id', 'calendario_id'];

    public $timestamps = false;
}
