<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     
      http://apilaravel.test/api/v1/products/1/transactions
     Este enpoint determina el las transacciones que tuvo el producto with  id = 1
     */
    public function index(Product $product)
    {
        $transaction = $product->transactions;
        return $this->showAll($transaction);
    }

    
}
