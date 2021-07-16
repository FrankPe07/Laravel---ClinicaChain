<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Medico;

class CitaController extends Controller
{

    public function citas_para_medico()
    {
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();
        $citas_medico = DB::select('CALL SP_CITAS_MEDICO(?)', array( $med->id ));

        return response()->json([
            'resp' => true,
            'citas_medico' => $citas_medico
        ]);
    }
    
    public function store( Request $request )
    {
        Cita::create([
            'medico_id' => $request->medico,
            'paciente_id' => $request->paciente,
            'programacion_id' => $request->programacion,
            'especialidad_id' => $request->especialidad,
            'descripcion_cita' => $request->descripcion
        ]);

        return response()->json([
            'resp' => true,
            'message' => 'Cita creada con exito'
        ]);
        
    }

    public function update( Request $request)
    {
        Cita::findOrFail( $request->idCita )->update([
            'condicion' => false
        ]);

        return response()->json([
            'resp' => true,
            'message' => 'Cita actualizada con exito'
        ]);
    }
}
