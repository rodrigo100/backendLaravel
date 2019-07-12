<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*productos que pertenecen  a un a categoria
     *  http://apilaravel.test/api/v1/categories/2/products
         Este enpoint determina los productos que son parte de la categoria  con id = 2 
    */
    public function index(Category $category)
    {
        $productos = $category->products;

        return $this->showAll($productos);
    }

   
}
