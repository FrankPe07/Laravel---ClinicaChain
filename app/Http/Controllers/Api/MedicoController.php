<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Especialidades;
use App\Models\TipoEspecialidad;
use App\Models\Persona;
use App\Models\User;

class MedicoController extends Controller
{
    
    public function index()
    {
        $persona = Persona::where('id', \Auth::user()->persona_id )->first();
        $medico = Medico::where('medico.persona_id', \Auth::user()->persona_id )->first();
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();
        $especialidades = Especialidades::select('especialidad.id', 'tipo_especialidad.Especialidad', 'especialidad.medico_id')
                                            ->join('tipo_especialidad', 'especialidad.tipo_especialidad_id', '=', 'tipo_especialidad.id' )
                                            ->where('especialidad.medico_id', '=', $med->id )
                                            ->get();

        return response()->json([
            'resp' => true,
            'medico' => $medico,
            'persona' => $persona,
            'especialidades' => $especialidades
        ]);
    }

    public function top_medicos(){

        $med = DB::select('CALL SP_TOP_MEDICOS()');

        return response()->json([
            'resp' => true,
            'top_medicos'  => $med
        ]);
    }

    public function store( Request $request )
    {
        $this->validate( $request, [
            'nombre'        => 'required',
            'apellidos'     => 'required',
            'dni'           => 'required',
            'correo'        => 'required',
            'contrasena'    => 'required',
            'descripcion'   => 'required',
            'dconsulta'     => 'required',
            'cpm'           => 'required',
            'rne'           => 'required',
        ]);

        try{
            DB::beginTransaction();

            $persona = Persona::create([
                'nombre'    => $request->nombre,
                'apellidos' => $request->apellidos,
                'dni'       => $request->dni,
                'fecha_nacimiento' => $request->nacimiento,
                'estado'    => true
            ]);
            
            User::create([
                'persona_id' => $persona->id,
                'usuario'    => $persona->nombre,
                'email'      => $request->correo,
                'password'   => bcrypt($request->contrasena),
                'rol_id'     => 3
            ]);

            Medico::create([
                'description'        => $request->descripcion,
                'direccion_consulta' => $request->dconsulta,
                'cpm'                => $request->cpm,
                'rne'                => $request->rne,
                'persona_id'         => $persona->id,
            ]);

            DB::commit();

            return response()->json([
                'resp' => true,
                'message' => 'Medico Agregado con Exito',
            ]); 


        }catch(\Throwable $th){
            return response()->json([
                'resp' => false,
                'message' => 'Error al agregar un medico',
            ]); 
            DB::rollback();
        }
    }

    public function update( Request $request )
    {

        $this->validate( $request, [
            'nombre' => 'required',
            'apellidos' => 'required',
            'sexo' => 'required',
            'lugar_nacimiento' => 'required',
            'desc_medica' => 'required',
            'consultorio' => 'required'
        ]);

        try{
            DB::beginTransaction();

            $persona = Persona::findOrFail( \Auth::user()->persona_id );
            $persona->nombre    = $request->nombre;
            $persona->apellidos = $request->apellidos;
            $persona->genero    = $request->sexo;
            $persona->lugar_nacimiento = $request->lugar_nacimiento;
            $persona->save();

            $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

            $medico = Medico::findOrFail( $med->id );
            $medico->description  = $request->desc_medica;
            $medico->direccion_consulta  = $request->consultorio;
            $medico->save();


            DB::commit();  

            return response()->json([
                'resp' => true, 
                'message' => 'Medico actualizado con Exito',
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'resp' => false,
                'message' => 'Sin exito al actualizar medico'
            ]);
            DB::rollback();
        }
        
    }

    public function addEspecialidad( Request $request )
    {
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

        $id_espe = $request->especialidades;

        $array = preg_split('/[^0-9]+/i', $id_espe);

        $array_sin_espacios = array_filter($array, function($dato){
            if($dato == ''){
                return false;
            }else{
                return true;
            }
        });

        $cont = 1;

        while( $cont <= count($array_sin_espacios) ){ 

            $esp = new Especialidades();
            $esp->tipo_especialidad_id = $array_sin_espacios[$cont];
            $esp->medico_id = $med->id;
            $esp->save();
            $cont = $cont + 1;
        }

        return response()->json([
            'resp' => true,
            'message' => 'Exito al agregar especialidades'
        ]);

    }

    public function deleteEspecialidad( Request $request, $idEspecialidad )
    {
        Especialidades::findOrFail( $idEspecialidad )->delete();

        return response()->json([
            'resp' => true,
            'message' => 'Especialidad Eliminada con exito'
        ]);
    } 



}
