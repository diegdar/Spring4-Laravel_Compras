<?php

namespace App\Http\Controllers;

use App\Http\Requests\validationProductPurchase;
use App\Http\Requests\validationPurchase;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\ControllerMethods;

/*
🗒️NOTAS:
1: Devuelve el importe total actual de la compra
*/

class ProductPurchaseController extends Controller
{
    use ControllerMethods;

    public function store(Request $request)
    {
        // var_dump($request);

        $unitPrice = (float) str_replace(',', '.', $request->unit_price);
        $this->CheckDuplicatedProducts($request, $unitPrice);

        $purchase_id =  $request->purchase_id;
        $totalImport = $this->calculateTotalImport($purchase_id);

        return view('productPurchases.create')->with([
            'purchase_id' => $purchase_id,
            'purchase_date' => $request->purchase_date,
            'supermarket' => $request->supermarket,
            'totalImport' =>  $totalImport,
            'products' => $this->getAllProducts(),
            'sortedProducts' => $this->getSortedProducts(),
            'productsPurchases' => $this->getSortedPurchasesById(),
        ]);
    }
  

    // Funcion auxiliar para comprobar que no haya sido añadido el mismo producto a la compra y sin o es asi lo añade
    private function CheckDuplicatedProducts($request, float $unitPrice)
    {
        // var_dump($request);
        return ProductPurchase::firstOrCreate([
            'purchase_id' => $request->purchase_id,
            'product_id' => $request->product_id,
        ], [
            'quantity' => $request->quantity,
            'unit_price' => $unitPrice,
            'import' => $request->quantity * $unitPrice,
        ]);
    }

    // Elimina un producto de la compra
    public function destroy(ProductPurchase $productPurchase, Request $purchase)
    {
        $productPurchase->delete(); // Elimina la compra de producto

        $purchase_id = $purchase->purchase_id;
        $totalImport = $this->calculateTotalImport($purchase_id); //nota 1

        return view('productPurchases.create')->with([
            'purchase_id' => $purchase_id,
            'purchase_date' => $purchase->purchase_date,
            'supermarket' => $purchase->supermarket,
            'totalImport' =>  $totalImport,
            'products' => $this->getAllProducts(),
            'sortedProducts' => $this->getSortedProducts(),
            'productsPurchases' => $this->getSortedPurchasesById(),
        ]);
    }

}
