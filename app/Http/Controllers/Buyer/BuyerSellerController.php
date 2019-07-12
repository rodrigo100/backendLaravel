<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
         /*con with traemos a sus relaciones secundarias functiones dentro del recurso Transaction esta la relacion  product y dentro del recurso Product  esta la relacion seller, ambas relaciones son metodos
         con el pluck obtenemos solo los campos necesario*/
        $vendedor = $buyer->transactions()
        ->with('product.seller')
        ->get()
        ->pluck('product.seller')
        ->unique('id')
        ->values();

        return $this->showAll($vendedor);
    }

   
}
