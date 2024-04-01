<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\ProductPurchase;

trait ControllerMethods
{
  // **Obtener las compras de productos ordenadas por id descendente**
  private function getSortedPurchasesById()
  {
    return ProductPurchase::orderBy('id', 'desc')->get();
  }

  // **Obtener productos ordenados por descripcion**
  private function getSortedProducts()
  {
    return Product::whereNull('deleted_at') //Devuelve los productos que NO han sido eliminados en la tabla 'products'
      ->orderBy('description')
      ->get();
  }

  // **Obtener todos los productos**
  private function getAllProducts()
  {
    return Product::withTrashed()->get(); //Devuelve TODOS los productos esten elimados o no en la tabla 'products'
  }

  // **obtener el importe total de una compra**
  public function calculateTotalImport($purchaseId): float
  {
      $totalImport = ProductPurchase::where('purchase_id', $purchaseId)->sum('import');
      return $totalImport;
  }

}
