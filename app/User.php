<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
 use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
     use Notifiable,SoftDeletes;

    const USUARIO_VERIFICADO ='1';
    const USUARIO_NO_VERIFICADO = '0';
    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';
    /**
      * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verified', 'verification_token', 'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_token','created_at','updated_at','verified','deleted_at',
    ];
      protected $dates =['deleted_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    protected $table= 'users';

    //mutador > alterar el atributo antes de realizar la inserccion en la base de datos caracter especial"set"
    //MUTADOR QUE CONVIERTE A MINUSCULAS EL ATRIBUTO NAME
    public function setNameAttribute($valor)
    {
        $this->attributes['name']= strtolower($valor);
    }
    //MUTADOR QUE CONVIERTE A MINUSCULAS EL ATRIBUTO EMAIL
    public function setEmailAttribute($valor)
    {
        $this->attributes['email']= strtolower($valor);
    }
   //accesor > alterar el atributo para obtner l oque se encuentra en la base de datos caracter especial"get"
    //ACCESOR QUE CONVIERTE A MAYUSCULAS CADA INICIO DE PALABR DEL ATRIBUTO NAME
    public function getNameAttribute($valor)
    {
        return ucwords($valor);
    }
   

    public function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }
    
    public function esAdministrador()
    {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }
    
    public static  function generarVerificationToken()
    {
        return str_random(40);
    }
}
