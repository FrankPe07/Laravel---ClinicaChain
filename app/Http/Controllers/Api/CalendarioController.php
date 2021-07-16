<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fecha;
use App\Models\Horas;
use App\Models\Hora;
use App\Models\Calendario;
use App\Models\Medico;
use App\Models\ProgramacionMedica;

class CalendarioController extends Controller
{
    
    public function index( Request $request )
    {
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

        $calendario = DB::select('CALL SP_CALENDARIO_MEDICO(?,?,?)', array( $med->id, $request->mes, $request->year));

        return response()->json([
            'resp' => true,
            'calendario' => $calendario
        ]);
    }

    public function indexMeseCalendario()
    {
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

        $meses = DB::select('CALL SP_MESES_CALENDARIO(?)', array( $med->id ));

        return response()->json([
            'resp' => true,
            'meses' => $meses
        ]);
    }
    
    public function indexHora()
    {
        $horas = Hora::all();
        return response()->json([
            'resp' => true,
            'horas' => $horas
        ]);
    }

    public function horas_por_mes( Request $request )
    {
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

        $horas = DB::select('CALL SP_HORAS_POR_MESES(?,?,?,?)', array( $request->dia, $request->mes, $request->anno ,$med->id ));

        return response()->json([
            'resp' => true,
            'horas' => $horas
        ]);
    }

    public function horas_por_mes_para_paciente( Request $request )
    {
        $horas = DB::select('CALL SP_HORAS_POR_MESES(?,?,?,?)', array( $request->dia, $request->mes, $request->anno ,$request->idMedico ));

        return response()->json([
            'resp' => true,
            'horas' => $horas
        ]);
    }

    public function store( Request $request )
    {
        $fecha_mes = Fecha::where('fecha.dia', $request->dia )->exists();

            if( $fecha_mes == 1) {

                $idFecha = Fecha::select('id')->where('fecha.dia', $request->dia )->first();
                $idCalendario = Calendario::select('id')->where('calendario.fecha_id', $idFecha->id )->first();

                try{

                    DB::beginTransaction();

                    $id_horas = $request->horas;

                    $array = preg_split('/[^0-9]+/i', $id_horas);

                    $array_sin_espacios = array_filter($array, function($dato){
                        if($dato == ''){
                            return false;
                        }else{
                            return true;
                        }
                    });

                    $cont = 1;

                    while( $cont <= count($array_sin_espacios) ){ 

                        $horas = new Horas();
                        $horas->hora_id = $array_sin_espacios[$cont];
                        $horas->calendario_id = $idCalendario->id;
                        $horas->save();
                        $cont = $cont + 1;
                    }

                    DB::commit();
                    
                    return response()->json([
                        'resp' => true,
                        'mess' => 'Calendario medico agregado con exito',
                        '1' => 1
                    ]);

                }catch(\Throwable $th){
                    return response()->json([
                        'resp' => false,
                        'message' => 'Sin exito'
                    ]);
                    DB::rollback();
                }

            } else {

                try{ 

                    DB::beginTransaction();

                    $fecha = Fecha::create([
                        'dia' => $request->dia,
                        'mes' => $request->mes,
                        'anno'=> $request->anno
                    ]);

                    $calendario = Calendario::create([ 
                        'fecha_id' => $fecha->id
                    ]);

                    $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

                    $pmedica = ProgramacionMedica::create([
                        'calendario_id' => $calendario->id,
                        'medico_id'     => $med->id
                    ]);


                    $id_horas = $request->horas;

                    $array = preg_split('/[^0-9]+/i', $id_horas);

                    $array_sin_espacios = array_filter($array, function($dato){
                        if($dato == ''){
                            return false;
                        }else{
                            return true;
                        }
                    });

                    $cont = 1;

                    while( $cont <= count($array_sin_espacios) ){ 

                        $horas = new Horas();
                        $horas->hora_id = $array_sin_espacios[$cont];
                        $horas->calendario_id = $calendario->id;
                        $horas->save();
                        $cont = $cont + 1;
                    }
                    
                    DB::commit();
                    
                    return response()->json([
                        'resp' => true,
                        'mess' => 'Calendario medico agregado con exito',
                        '2' => 2
                    ]);

                }catch(\Throwable $th){
                    return response()->json([
                        'resp' => false,
                        'message' => 'Sin exito'
                    ]);
                    DB::rollback();
                }
            }
   
    }

    public function delete_horas_by_mes( Request $request )
    {
        Horas::findOrFail( $request->idhoras )->delete();
        return response()->json([
            'resp' => true
        ]);
    }


}
