<?php

namespace App;
use App\Transaction;
use App\Scopes\BuyerScope;
class Buyer extends User
{
   
   /*Constructor del Modelo*/
   protected static function boot()
   {	
     parent::boot();
     static::addGlobalScope(new BuyerScope);

   }
   public function transactions()
   {
   	   return $this->hasMany(Transaction::class);
   }
  //hola
}
