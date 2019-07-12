<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;


class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= User::all();
        return $this->showAll($user);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

         $this->validate($request, $reglas);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;

        $usuario = User::create($campos);
         return $this->showOne($usuario, 201);
    }
     /* Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //finOrFail devuelve el tipo de excepcion 404 not found, 
        // $user=User::findOrFail($id);
         return $this->showOne($user);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
        // $user =User::findOrFail($id);
       $reglas = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ];

        $this->validate($request, $reglas);
           $this->validate($request, $reglas);

         if ($request->has('name'))
         {
             $user->name= $request->name;

         }
         if ($request->has('email') && $user->email != $request->email)
         {
             $user->verified = User::USUARIO_NO_VERIFICADO;
             $user->verification_token = User::generarVerificationToken();
             $user->email = $request->email;            
         }
         if ($request->has('password'))
         {
             $user->password= bcrypt($request->password);
         }
         if ($request->has('admin'))
         {
             if(!$user->esVerificado())
             {
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador',409);
                //codigo 409, significa conflictos en la accion solicitada
             }
             $user->admin= $request->admin;
         }
         //preguntar si no algun valor original  a cambiado, respecto a lo que se quiere actulizar
         if(!$user->isDirty())
         {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar','code',422);
            //codigo 409, significa una peticion mal solicitada
         }

         $user->save();
        return $this->showOne($user);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*se envia como inyeccion de dependencia el modelo */
    public function destroy(User $user)
    {
        // $user = User::findOrFail($id);
        $user->delete();
        return $this->showOne($user);
    }
}
