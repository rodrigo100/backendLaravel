<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
         $producto = $seller->products()->get();
         return $this->showAll($producto);

    }
      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      /*
     ENDPOINT DE TIPO POST con la siguiente url
      http://apilaravel.test/api/v1/sellers/48/products*/
    public function store(Request $request, User $seller)
    {
          $rules=
          [
                'name'=> 'required',
                'description'=> 'required',
                'quantity'=>'required|integer|min:1',
                'image'=>'required|image',
          ];

          $this->validate($request,$rules);

          $data=$request->all();

          $data['status']= Product::PRODUCTO_NO_DISPONIBLE;
          $data['image'] = 'producto1.jpg';
          $data['seller_id'] = $seller->id;

           // dd($data);
          $producto = Product::create($data);

          return $this->showOne($producto,201);

    }

     public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in: ' . Product::PRODUCTO_DISPONIBLE . ',' . Product::PRODUCTO_NO_DISPONIBLE,
            'image' => 'image',
        ];

        $this->validate($request, $rules);

         $this->verificarVendedor($seller, $product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->estaDisponible() && $product->categories()->count() == 0) {
                return $this->errorResponse('Un producto activo debe tener al menos una categoría', 409);
            }
        }

        // if ($request->hasFile('image')) {
        //     Storage::delete($product->image);

        //     $product->image = $request->image->store('');
        // }


        if ($product->isClean()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $product->save();

        return $this->showOne($product);
    }

  public function destroy(Seller $seller,Product $product)
  {
           $this->verificarVendedor($seller,$product);
           $product->delete();
           return $this->showOne($product);



  }
  protected function verificarVendedor($seller,$product)
  {
       if($seller->id != $product->seller_id)
       {
         throw new HttpException(422,'El vendedor especificado no es el vendedor real del producto');
         
       }
  }

}
