<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {

        if( $exception instanceof ModelNotFoundException ){
            return response()->json(['resp' => false , 'error' => 'Error de modelo'], 400 );
        }

        if( $exception instanceof QueryException ){
            return response()->json(['resp' => false , 'message' => 'Error de consulta a la base de datos', $exception->getMessage()], 400 );
        }

        if( $exception instanceof HttpException ){
            return response()->json(['resp' => false , 'error' => 'Error en ruta'], 404 );
        }

        if( $exception instanceof AuthenticationException ){
            return response()->json(['resp' => false , 'error' => 'Error de autenticacion '], 401 );
        }

        if( $exception instanceof ValidationException ){
            return response()->json(['resp' => false , 'error' =>  $exception->validator->errors() ], 400 );
        }

        

        return parent::render($request, $exception);

    }
}
