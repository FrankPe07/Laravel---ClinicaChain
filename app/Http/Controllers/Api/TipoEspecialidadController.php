<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TipoEspecialidad;
use Illuminate\Http\Request;

class TipoEspecialidadController extends Controller
{

    public function index()
    {

        $especialidad = TipoEspecialidad::select('id','Especialidad', 'Descripcion')->get();

        return response()->json([
            'resp' => true,
            'especialidad' => $especialidad,
            'message' => 'Especialidades Medicas'
        ]);

    }

    public function indexQuery( Request $request )
    {
        $buscar = $request->buscar;


        $especialidad = TipoEspecialidad::select('id', 'Especialidad', 'Descripcion')
                                            ->where('Especialidad', 'LIKE', '%'. $buscar.'%')
                                            ->orderBy('id', 'desc')
                                            ->get();
        return response()->json([
        'resp' => true,
        'especialidad' => $especialidad
        ]);
        
    }

    public function top_especialidades() {

        $especialidades = DB::select('CALL SP_TOP_ESPECIALIDADES()');

        return response()->json([
            'resp' => true,
            'top_especialidades' => $especialidades 
        ]);
    }

    public function store(Request $request)
    {
        TipoEspecialidad::create([
            'Especialidad' => $request->especialidad,
            'Descripcion'  => $request->descripcion
        ]);

        return response()->json([
            'resp'    => true,
            'message' => 'Especialidad agregada con exito'
        ]);
    }

    public function update(Request $request, $id )
    {
        TipoEspecialidad::findOrFail( $id )->update([
            'Especialidad' => $request->especialidad,
            'Descripcion' => $request->descripcion
        ]);

        return response()->json([
            'resp'    => true,
            'message' => 'Especialidad actualizada con exito'
        ]);
    }


    public function destroy( $id )
    {
        TipoEspecialidad::findOrFail( $id )->delete([]);
        return response()->json([
            'resp'    => true,
            'message' => 'Especialidad eliminada con exito'
        ]);
    }
}
