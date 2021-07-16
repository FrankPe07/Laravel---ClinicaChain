<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Persona;

class UsuarioController extends Controller
{


    public function login( Request $request )
    {
        
        if ( Auth::attempt(['email' => $request->correo, 'password' => $request->password ]) )
        {
            $user = User::whereEmail( $request->correo )->first();
            $usuario = User::select('rol_id','persona_id', 'email')->whereEmail( $request->correo )->first();
            $persona = Persona::select('nombre','apellidos', 'dni')->where('id', '=', $usuario->persona_id )->first();
            $token = $user->createToken('clinicachain')->accessToken;

            return response()->json([
                'resp'      => true,
                'token'     => $token,
                'rol_id'    => $usuario->rol_id,
                'persona_id'=> $usuario->persona_id,
                'correo'    => $request->correo,
                'nombre'    => $persona->nombre,
                'apellidos' => $persona->apellidos,
				'dni'		=> $persona->dni,
                'menssage'  => 'Bienvenido a Clinicachain'
            ], 200);

        } else {
            return response()->json([
                'resp' => false,
                'menssage' => 'Las credenciales introducidas son incorrectas'
            ], 200);
        }
    }


    public function logoutApi(Request $request)
    {

        auth('api')->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json([
            'rep' => true,
            'message' => 'Hasta luego'
        ], 200);
    
    }

}
