<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /*  http://apilaravel.test/api/v1/sellers/1//buyer
     Este enpoint determina todas los compradores  las cuales compraron algun producto que fue cargado por un vendedor en especifico  por id = 1,
      en otras palabras todos los compradores que compraron sus productos de un vendedor en especifico por id= 1*/
    public function index(Seller $seller)
    {
        $buyer = $seller->products()
        ->whereHas('transactions')
        ->with('transactions.buyer')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->pluck('buyer')
        ->unique('id')
        ->values();
        return $this->showAll($buyer);
    }

}
