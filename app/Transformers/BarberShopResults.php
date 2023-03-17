<?php

namespace App\Transformers;

class BarberShopResults
{
 public function handle(string $results)  {

     $cleanUp = str($results)->explode("\n");

     $cleanUp = collect($cleanUp)
         ->filter(fn($item) => !empty($item))
         ->values();

     return $cleanUp->toArray();
 }
}
