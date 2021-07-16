<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Parentesco;
use App\Models\Persona;
use App\Models\User;
use App\Models\Especialidades;

class PacienteController extends Controller
{
    
    public function index( Request $request )
    {
        $paciente = Paciente::where('paciente.persona_id', \Auth::user()->persona_id )->first();

        if($paciente->familia_id == null ){

            $grupo_familiar = DB::select('CALL SP_GRUPO_FAMILIAR(?,?)', array( $paciente->id , $paciente->persona_id));
            return response()->json([
                'resp' => true,
                'grupo_familiar' => $grupo_familiar,
            ]);
        } else{
            $grupo_familiar = DB::select('CALL SP_GRUPO_FAMILIAR(?,?)', array( $paciente->familia_id , $paciente->persona_id));

            return response()->json([
                'resp' => true,
                'grupo_familiar' => $grupo_familiar,
            ]);
        }
        
    }

    public function indexMisCitas()
    {
        $paciente = Paciente::where('paciente.persona_id', \Auth::user()->persona_id )->first();

        if( $paciente->familia_id == ''){

            $citas = DB::select('CALL SP_MIS_CITAS_PACIENTE(?,?)', array( $paciente->id , $paciente->id));

            return response()->json([
                'resp' => true,
                'citas' => $citas,
            ]);
        
        } else {
            
            $citas = DB::select('CALL SP_MIS_CITAS_PACIENTE(?,?)', array( $paciente->id , $paciente->familia_id ));

            return response()->json([
                'resp' => true,
                'citas' => $citas,
            ]);
        }
    }

    public function parentesco()
    {
        $parentesco = Parentesco::all();

        return response()->json([
            'resp' => true,
            'parentesco' => $parentesco
        ]);
    }

    public function store( Request $request )
    {
        $this->validate( $request, [
            'nombre'    => 'required',
            'apellidos' => 'required',
            'genero'    => 'required',
            'domicilio' => 'required',
            'dni'       => 'required',
            'ocupacion' => 'required',
            'lugar_nacimiento'  => 'required',
            'estado_civil'      => 'required',
            'grupo_sanguineo'   => 'required',
            'parentesco'    => 'required',
            'correo'        => 'required',
            'contrasena'    => 'required',
        ]);

        try{

            // $historialCount = DB::table('paciente')->count();

            // if( $historialCount < 10 ){
            //     $codHistorial = 'HCE00'. $historialCount + 1;
            // }
            
            DB::beginTransaction();

            $persona = new Persona();
            $persona->nombre    = $request->nombre;
            $persona->apellidos = $request->apellidos;
            $persona->genero    = $request->genero;
            $persona->domicilio = $request->domicilio;
            $persona->dni       = $request->dni;
            $persona->ocupacion = $request->ocupacion;
            $persona->lugar_nacimiento  = $request->lugar_nacimiento;
            $persona->fecha_nacimiento  = $request->fecha_nacimiento;
            $persona->estado_civil      = $request->estado_civil;
            $persona->imagen    = null;
            $persona->estado    = true;
            $persona->save();
    
            $idFamilia = Paciente::select('paciente.id')->where('paciente.persona_id', '=', \Auth::user()->persona_id )->first();
    
            $paciente = new Paciente();
            $paciente->persona_id       = $persona->id;
            $paciente->grupo_sanguineo  = $request->grupo_sanguineo;
            $paciente->familia_id       = $idFamilia->id;
            $paciente->parentesco_id    = $request->parentesco;
            $paciente->save();
            
            $user = new User();
            $user->persona_id   = $persona->id;
            $user->usuario      = $request->nombre;
            $user->email        = $request->correo;
            $user->password     = bcrypt( $request->contrasena );
            $user->rol_id       = 2;
            $user->save();
    
            DB::commit();
            
            return response()->json([
                'resp' => true,
                'message' => 'Paciente Agregado con Exito',
                ]); 
                
                
            }catch(\Throwable $th){ 
                return response()->json([
                    'resp' => false,
                    'message' => 'Sin exito'
                ]);
            DB::rollback();
        }
    }

    public function update( Request $request )
    {
        $this->validate( $request, [
            'nombre'    => 'required',
            'apellidos' => 'required',
            'genero'    => 'required',
            'domicilio' => 'required',
            'ocupacion' => 'required',
            'lugar_nacimiento'  => 'required',
            'estado_civil'      => 'required',
            'grupo_sanguineo'   => 'required',
            'parentesco'    => 'required',
        ]);

        try{

            DB::beginTransaction();

            $persona = Persona::findOrFail( $request->idPersona );
            $persona->nombre            = $request->nombre;
            $persona->apellidos         = $request->apellidos;
            $persona->genero            = $request->genero;
            $persona->domicilio         = $request->domicilio;
            $persona->ocupacion         = $request->ocupacion;
            $persona->lugar_nacimiento  = $request->lugar_nacimiento;
            $persona->fecha_nacimiento  = $request->fecha_nacimiento;
            $persona->estado_civil      = $request->estado_civil;
            $persona->save();

            $paciente = Paciente::findOrFail( $request->idPaciente );
            $paciente->grupo_sanguineo   = $request->grupo_sanguineo;
            $paciente->parentesco_id     = $request->parentesco;
            $paciente->save();


            DB::commit();

            return response()->json([
                'resp' => true, 
                'message' => 'Paciente actualizado con Exito',
            ]);

        }catch(\Throwable $th){
            return response()->json([
                'resp' => false,
                'message' => 'Sin exito al actualizar'
            ]);
            DB::rollback();
        }
    }

    public function registro_paciente( Request $request )
    {
        $this->validate( $request, [
            'nombre'     => 'required',
            'apellidos'  => 'required',
            'dni'        => 'required',
            'correo'     => 'required',
            'contrasena' => 'required',
            'sanguineo'  => 'required',
            'parentesco' => 'required',
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
                'rol_id'     => 2
            ]);

            Paciente::create([
                'persona_id' => $persona->id,
                'grupo_sanguineo' => $request->sanguineo,
                'parentesco_id' => $request->parentesco
            ]);


            DB::commit();

            return response()->json([
                'resp' => true,
                'message' => 'Paciente Agregado con Exito',
            ]); 

        }catch(\Throwable $th){
            return response()->json([
                'resp' => false,
                'message' => 'Error al agregar un paciente',
            ]); 
            DB::rollback();
        }

    }

    public function especialistas( Request $request )
    {
        $especialistas = DB::select('CALL SP_ESPECIALISTAS(?)', array( $request->idTipoEspecialidad ));
        return response()->json([
            'resp' => true,
            'especialistas' => $especialistas
        ]);
    }

    public function servicios_by_idmedico( Request $request )
    {
        $servicios = DB::select('CALL SP_SERVICIOS_BY_MEDIDCO(?)', array( $request->idMedicoServicio ));
        return response()->json([
            'resp' => true,
            'especialistas' => $servicios
        ]);
    }

    public function selectPaciente()
    {
        $paciente = Paciente::where('paciente.persona_id', \Auth::user()->persona_id )->first();

        if($paciente->familia_id == null ){

            $grupo_familiar = DB::select('CALL SP_SELECT_PACIENTE(?,?)', array( $paciente->id , $paciente->persona_id));
            return response()->json([
                'resp' => true,
                'grupo_familiar' => $grupo_familiar,
            ]);
        } else{
            $grupo_familiar = DB::select('CALL SP_SELECT_PACIENTE(?,?)', array( $paciente->familia_id , $paciente->persona_id));

            return response()->json([
                'resp' => true,
                'grupo_familiar' => $grupo_familiar,
            ]);
        }
    }

    public function indexFechaHora( Request $request )
    {

        $fechas = DB::select('CALL SP_CALENDARIO_MEDICO(?,?,?)', array( $request->idmedico, $request->mes, $request->year ));

        return response()->json([
            'resp' => true,
            'fechas' => $fechas
        ]);
    }

}
