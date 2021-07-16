<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutorizacionHCE extends Model
{
    use HasFactory;

    protected $table = 'autorizacion_hce';

    protected $fillable = [
        'cita_id',
        'token_cod'
    ];
    
}
