<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Api\TipoEspecialidadController;
use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\MedicoController;
use App\Http\Controllers\Api\ServiciosController;
use App\Http\Controllers\Api\CalendarioController;
use App\Http\Controllers\Api\CitaController;
use App\Http\Controllers\Api\ResenaController;
use App\Http\Controllers\Api\AutorizationHceController;
use App\Http\Controllers\Api\HistorialClinicoController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::post('login', [ UsuarioController::class, 'login']);
Route::post('logoutApi', [ UsuarioController::class, 'logoutApi']);

Route::get('parentesco-sin-token', [ PacienteController::class, 'parentesco']);
Route::post('registro-paciente', [ PacienteController::class, 'registro_paciente']);
Route::post('registro-medico', [ MedicoController::class, 'store']);


Route::group(['middleware' => ['auth:api']], function (){
    
    Route::get('persona', [ PersonaController::class, 'index']);
    
    //Modulo Administrador
    Route::get('especialidad', [ TipoEspecialidadController::class, 'index']);
    Route::post('/especialidad', [TipoEspecialidadController::class , 'store']);
    Route::put('/especialidad/{id}', [TipoEspecialidadController::class , 'update']);
    Route::delete('/especialidad/{id}', [TipoEspecialidadController::class , 'destroy']);
    
    // Modulo Paciente
    Route::get('grupo-familiar', [ PacienteController::class, 'index']);
    Route::get('parentesco', [ PacienteController::class, 'parentesco']);
    Route::post('grupo-familiar', [PacienteController::class, 'store']);
    Route::put('grupo-familiar', [PacienteController::class, 'update']);
    Route::get('especialidad-query', [ TipoEspecialidadController::class, 'indexQuery']);
    
    Route::get('especialistas', [ PacienteController::class, 'especialistas']);
    Route::get('servicio-by-medico', [ PacienteController::class, 'servicios_by_idmedico']);
    Route::get('select-paciente', [PacienteController::class , 'selectPaciente']);
    Route::get('fecha-hora', [PacienteController::class , 'indexFechaHora']);
    Route::get('horas-by-mes-para-paciente', [ CalendarioController::class , 'horas_por_mes_para_paciente']);
    Route::post('create-cita-paciente', [ CitaController::class, 'store']);
    Route::get('mis-citas', [PacienteController::class , 'indexMisCitas']);
    Route::put('update-cita-condicion', [ CitaController::class, 'update']);
    Route::post('create-resena', [ ResenaController::class, 'store']);

    Route::post('autorization-token-hce', [ AutorizationHceController::class, 'store']);
    Route::get('validate-token-hce', [ AutorizationHceController::class, 'index']);
    

    // Modulo Medico
    Route::get('medico', [MedicoController::class, 'index']);
    Route::put('medico', [MedicoController::class, 'update']);
    Route::post('addEspecialidadMedica', [MedicoController::class, 'addEspecialidad']);
    Route::delete('deleteEspecialidad/{idEspecialidad}', [ MedicoController::class , 'deleteEspecialidad']);

    Route::get('servicios-precios', [ ServiciosController::class , 'index']);
    Route::get('tipo-servicio', [ ServiciosController::class , 'tipo_servicio']);
    Route::post('tipo-servicio', [ ServiciosController::class , 'store']);
    Route::put('tipo-servicio', [ ServiciosController::class , 'update']);

    Route::post('add-calendario', [ CalendarioController::class , 'store']);
    Route::get('calendario-medico', [ CalendarioController::class , 'index']);
    Route::get('calendario-meses', [ CalendarioController::class , 'indexMeseCalendario']);
    Route::get('horas-by-mes', [ CalendarioController::class , 'horas_por_mes']);
    Route::delete('delete-hora-by-mes', [ CalendarioController::class , 'delete_horas_by_mes']);
    Route::get('horas-index', [ CalendarioController::class , 'indexHora']);
    Route::get('citas-para-medico', [ CitaController::class , 'citas_para_medico']);
    Route::get('resenas-para-medico', [ ResenaController::class , 'resenas_para_medico']);

    Route::get('historial-clinico-paciente', [ HistorialClinicoController::class , 'index']);

    // Routes Home
    Route::get('top-medicos-home',   [MedicoController::class, 'top_medicos']);
    Route::get('top_especialidades', [TipoEspecialidadController::class, 'top_especialidades']);
    
});