<?php

use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

    	//anular llaves foraneas al momento de limpiar()
    	DB::statement('SET FOREIGN_KEY_CHECKS =0;');
       //limpindo los items de las tablas correspondietes al modelo
       User::truncate();
       Category::truncate();
       Product::truncate();
       Transaction::truncate();
       DB::table('category_product')->truncate();

       
        // establecer la cantidad de datos a crear por modelo para pasar al factory

       	$cantidadUsuarios=1000;
       	$cantidadCategorias=30;
       	$cantidadProductos=1000;
       	$cantidadTransacciones=1000;

          //pasar las cantidades al factory
       	factory(User::class,$cantidadUsuarios)->create();
       	factory(Category::class,$cantidadCategorias)->create();
       	factory(Product::class,$cantidadProductos)->create()->each(

          function($product)
          {
               $categoria= Category::all()->random(mt_rand(1,5))->pluck('id');
               $product->categories()->attach($categoria);


          } 

       	);
       	factory(Transaction::class,$cantidadTransacciones)->create();
          //asignar llaves foraneas al momento de limpiar()
            // DB::statement('SET FOREIGN_KEY_CHECKS =1;');

    }
}
