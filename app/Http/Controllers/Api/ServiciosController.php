<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicios;
use App\Models\Medico;
use App\Models\Persona;
use App\Models\TipoServicio;

class ServiciosController extends Controller
{

    public function index()
    {
        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

        $servicios = Servicios::with(['tipo_servicio'])->where('medico_id', $med->id )->get();

        return response()->json([
            'resp' => true,
            'servicios' => $servicios
        ]);
    }

    public function tipo_servicio()
    {
        $ts = TipoServicio::select('id', 'nombreServicio')->get();

        return response()->json([
            'resp' => true,
            'tipo_servicio' => $ts
        ]);
    }

    public function store(Request $request)
    {
        $this->validate( $request, [
            'tipo_servicio' => 'required',
            'descripcion'   => 'required',
            'precio'        => 'required'
        ]);

        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

        Servicios::create([
            'tipo_servicio_id'  => $request->tipo_servicio,
            'descripcion'       => $request->descripcion,
            'precio'            => $request->precio,
            'medico_id'         => $med->id
        ]);

        return response()->json([
            'resp'    => true,
            'message' => 'Especialidad creada con exito'
        ]);
    }

    public function update(Request $request, Servicios $servicios)
    {
        $this->validate( $request, [
            'tipo_servicio' => 'required',
            'descripcion'   => 'required',
            'precio'        => 'required'
        ]);

        $med = Medico::select('id')->where('medico.persona_id', \Auth::user()->persona_id)->first();

        Servicios::findOrFail( $request->idServicio )->update([
            'tipo_servicio_id'  => $request->tipo_servicio,
            'descripcion'       => $request->descripcion,
            'precio'            => $request->precio,
            'medico_id'         => $med->id
        ]);

        return response()->json([
            'resp'    => true,
            'message' => 'Especialidad actualizada con exito'
        ]);
    }


    public function destroy(Servicios $servicios)
    {
        //
    }
}
