<?php

namespace App\Http\Controllers\Buyer;
use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compradores = Buyer::has('transactions')->get();
        /*pasar al metodo showAll que se encuentra en el Traits/ApiResponser.php */
        return $this->showAll($compradores);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
         // $comprador = Buyer::has('transactions')->findOrFail($id);
         return $this->showOne($buyer);
    }

   }
