<?php

namespace App\Models;


use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; 

    protected $fillable = [
        'persona_id',
        'usuario',
        'email',
        'email_verified_at',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // protected $casts = [
    //     'email_verified' => 'datetime',
    // ];

    public function persona()
    {
        return $this->belongsTo( 'App\Models\Persona' , 'persona_id', 'id');
    }

    public function rol()
    {
        return $this->belongsTo( 'App\Models\Roles', 'rol_id', 'id');
    }


}
