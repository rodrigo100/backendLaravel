<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /*Objetivo de esta consulta es listr los vendedores que se ecnutran presentes en una transaccion

    http://apilaravel.test/api/v1/sellers/1//transactions
     Este enpoint determina todas las transaciones en las cuales a estado presente un seller en especifico id = 1,
      en otras palabras cuantos productos fueron comercializados por el vendedor(seller) en especifico*/
    public function index(Seller $seller)
    {
        $transacciones = $seller->products()
        ->whereHas('transactions')
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse();

        return $this->showAll($transacciones);
    }

 
}
