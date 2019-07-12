<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     
        http://apilaravel.test/api/v1/buyers/7/categories
        este enpoint quiere decir listar todos los categorias de los productos que compro el comprador con id = 7
     */
     public function index(Buyer $buyer)
    {
         $categorias = $buyer->transactions()
         ->with('product.categories')
        ->get()
        ->pluck('product.categories')
        ->collapse()
        ->unique('id')
        ->values();

        return $this->showAll($categorias);
    }
}
