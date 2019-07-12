<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
// use Illuminate\Support\Collection;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*Objetivo de esta consulta es listar los vendedores que se encuentran presentes en una transaccion determinada por el ID

    http://apilaravel.test/api/v1/transactions/1/sellers
     Este enpoint determina el vendedor de las transaccion del id = 1
    */
    public function index(Transaction $transaction)
    {
        $seller = $transaction->product->seller;
        return $this->showOne($seller);
        
    }

   
}
