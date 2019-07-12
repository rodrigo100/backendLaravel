<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        /*
       * La relacion transaction() quiere decir que ingresamos a la funcion como tal y no asi a la relacion, el cual retorna una collecion
       * La clausula que sigue al devolver una coleccion, que tambien traiga productos con   "with('product')"
       * si aplicamos pluck('product') obtendremos solo los productos de la transaction
       *  http://apilaravel.test/api/v1/buyers/2/products
         Este enpoint determina los prodcutos de una transaccion que el comprador(buyer) con id = 2 haya comprado
         */
        $producto= $buyer->transactions()->with('product')
        ->get()
        ->pluck('product');
        // dd($producto);
        return $this->showAll($producto);
    }

   
}
