<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Persona;

class HistorialClinicoController extends Controller
{

    public function index( Request $request )
    {

        $historial = DB::select('CALL SP_LISTADO_HISTORIAL_CLINICO_PACIENTE(?)', array( $request->idPaciente ));
        $paciente  = Paciente::where('paciente.id', $request->idPaciente )->first();
        $persona   = Persona::where('id', $paciente->persona_id )->first(); 

        return response()->json([
            'resp' => true,
            'paciente' => $paciente,
            'persona' => $persona,
            'historial' => $historial,
        ]);
    }
}
