<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\AutorizacionHCE;

class AutorizationHceController extends Controller
{

    public function index( Request $request )
    {
        $cod = AutorizacionHCE::where('cita_id', $request->cita_id )->where( 'token_cod' , $request->codtoken )->exists();

        if( $cod ){
            $aut = AutorizacionHCE::select('id')->where('cita_id', $request->cita_id )->where( 'token_cod' , $request->codtoken )->first();
            AutorizacionHCE::findOrFail( $aut->id )->delete();
            return response()->json([ 'resp' => true ]);
        } else {
            return response()->json([ 'resp' => false ]);
        }

    }
    

    public function store( Request $request )
    {

        $cod = AutorizacionHCE::create([
            'cita_id'   => $request->cita_id,
            'token_cod' => $this->generarCodigo(6)
        ]);

        return response()->json([
            'resp' => true,
            'token' => $cod->token_cod
        ]);

    }



    function generarCodigo( $longitud ) {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud; $i++)
        {
            $key .= $pattern[mt_rand(0,$max)];
        } 
        return $key;
    } 
}
