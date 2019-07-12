<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     http://apilaravel.test/api/v1/categories/7/buyers
     Este endpoint lista a todos los compradores de una categoria en especifico con id=7
     */
    public function index(Category $category)
    {

        $compradores = $category->products()
        ->whereHas('transactions')   /*comprador es cunado realizo una transaccion*/
        ->with('transactions.buyer') /*incluir los datos de la relacion transactions*/
        ->get()
        ->pluck('transactions') /*retorna muchas colecciones por ende se usa collapse*/
        ->collapse() /*mostraara todsas las transacciones con su comprador(buyer)*/
        ->pluck('buyer') /*solo se quiere los buyer de relacion*/
        ->unique('id')  /*Restringir dublicados por el hecho que muchos compradores puden haber comprado muchos productos de la misma categoria*/
        ->values();/*obtner toods los valores que fueron quitados los duplicados*/
           // dd($compradores);
        return $this->showAll($compradores);
    }

    
   
}
