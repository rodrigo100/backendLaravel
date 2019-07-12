<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*Ojetivo del metodo, saber que categorias del producto, estan detro de las transacciones */

       /* http://apilaravel.test/api/v1/transactions/2/categories
          Este enpoint determina todas las categorias de la transacciones del id = 2  
       */
    public function index(Transaction $transaction)
    {
         $categoria= $transaction->product->categories;
         // dd($categoria);
         return $this->showAll($categoria);  

        

    }

   
}
