<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategorySellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
        http://apilaravel.test/api/v1/categories/7/sellers
        este enpoint quiere decir listar todos los vendedores de la categoria con id = 7
    */
    public function index(Category $category)
    {

         $vendedores= $category->products()
         ->with('seller') /*implementar con(with) la otra relacion */
         ->get()
         ->pluck('seller') /*solo filtrar por la coleccion*/
         ->unique('id') /*para que no se repitan los datos en este caso los vendedores "sellers"*/
         ->values(); /*quitar los valores en blanco*/
 

            return $this->showAll($vendedores);
         // dd($vendedores);
        
    }
}
