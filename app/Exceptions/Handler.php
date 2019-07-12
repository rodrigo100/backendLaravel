<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
     use ApiResponser;
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        /*Mostrar las expcepciones de forma comprensible gracias a los traits y no mostrar por defecto LA PAGINA 404 DE LARAVEL PAGE NOT FOUND*/

        /*Controlar excepciones de validacion*/
        // if($exception instanceof ValidationException)
        // {
        //     return $this->convertValidationExceptionToResponse($exception,$request);
        // }
        // /*Controlar excepciones de recurso no encontrato*/
        // if($exception instanceof ModelNotFoundException)
        // {
        //     $modelo= strtolower(class_basename($exception->getModel()));
        //     return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado",404);
        // }
        // /*Controlar excepciones de auntenticacion*/
        // if($exception instanceof AuthenticationException)
        // {
        //     return $this->unauthenticated($request,$exception);
        // }
        // /*Controlar excepciones de autorizacion a dichos recursos, codigo> 403 de no autorizado*/
        // if($exception instanceof AuthorizationException)
        // {
        //     return $this->errorResponse('No autorizado para ejecutar dicha accion.', 403);
        // }
        // Controlar excepciones de url incorrectas code:404 not foud
        // if($exception instanceof NotFoundHttpException)
        // {
        //     return $this->errorResponse('No se encontro la URL especificada.', 404);
        // }
        // /*Controlar excepciones de metodos no permitidos para su acceso*/
        // if($exception instanceof MethodNotAllowedHttpException)
        // {
        //     return $this->errorResponse('El metodo especificado en la peticion, no es valido o no se encuentra permitido', 405);
        // }
        // /*Controlar cualquier otra excepciones de tipo http*/
        // if($exception instanceof HttpException)
        // {
        //     return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        // }
        // /*Controlar excepciones de eliminacion de recursos, cunado estan vinculdas con otros recursos*/
        // if($exception instanceof QueryException)
        // {
        //      $codigo=$exception->errorInfo[1];
        //      if($codigo==1451)
        //      {

        //         return $this->errorResponse('No se puede Eliminar el recurso, de forma permanente, ya que se encuentra relacionado con otro recurso',409);
        //      }
        // }


        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof ModelNotFoundException) {
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado", 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('No posee permisos para ejecutar esta acción', 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('No se encontró la URL especificada', 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El método especificado en la petición no es válido', 405);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof QueryException) {
            $codigo = $exception->errorInfo[1];

            if ($codigo == 1451) {
                return $this->errorResponse('No se puede eliminar de forma permamente el recurso porque está relacionado con algún otro.', 409);
            }
        }
         /*Controlar excepciones internos como conexion a la base de datos*/
          if (config('app.debug')) {
            return parent::render($request, $exception);            
        }

        return $this->errorResponse('Falla inesperada. Intente luego', 500);    }




     
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        
        return $this->errorResponse('No autenticado.', 401);        
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }
}
