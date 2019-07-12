<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
        http://apilaravel.test/api/v1/categories/7/transactions
        Este endopoint devuelve todas las transacciones donde un producto estubo presente con una determinaa categoria con id=7

     */
    public function index(Category $category)
    {
        $transaccion = $category->products()
        ->whereHas('transactions')  /*donde unicamente tengan transacciones*/
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse();

        return $this->showAll($transaccion);
    }

    
}
