<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Resena;
use App\Models\Medico;

class ResenaController extends Controller
{
    
    public function resenas_para_medico()
    {
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();
        $resenas_medico = DB::select('CALL SP_RESENAS_MEDICO(?)', array( $med->id ));

        return response()->json([
            'resp' => true,
            'resenas_medico' => $resenas_medico
        ]);
    }

    public function store( Request $request )
    {
        Resena::create([
            'cita_id' => $request->idCita,
            'calificacion' => $request->calificacion,
            'opinion' => $request->opinion
        ]);
        return response()->json([
            'resp' => true,
            'message' => 'Resena creada con exito'
        ]);
    }
}
