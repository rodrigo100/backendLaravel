<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*La finalidad es listar todas las transacciones que realizo un combrador en especifico
    http://apilaravel.test/api/v1/buyers/12/transactions
     Este enpoint determina las transacciones del comprador(buyer) con id = 12
    */
    public function index(Buyer $buyer)
    {
        $transaction= $buyer->transactions;
        return $this->showAll($transaction);
    }

   
}
