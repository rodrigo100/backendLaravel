<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;


/*La finalidad de este controlador base es llamar a la clase ApiResponser(con funciones de respuestas ante solicitudes), para luego ser pasadas a los controladores que extienden de este controlador base*/
class ApiController extends Controller
{
	 /*Instanciamos la clase ApiResponser.php, para que luego los metodos sean consumiods en otros controladores que extiendan de este controlador Base*/
     use ApiResponser;
}
