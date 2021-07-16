<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;
use App\Models\User;

class PersonaController extends Controller
{
    
    public function index()
    {
        $usuario = User::select('persona_id','email')->where('id', \Auth::user()->id )->first();
        

        return response()->json([
            'resp' => true,
            'usuario' => $usuario,
            'persona' => $persona,
        ], 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Persona $persona)
    {
        //
    }

    public function edit(Persona $persona)
    {
        //
    }

    public function update(Request $request, Persona $persona)
    {
        //
    }

    public function destroy(Persona $persona)
    {
        //
    }
}
