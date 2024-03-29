<?php

namespace App\Http\Controllers;

use App\Http\Requests\validationProductPurchase;
use App\Http\Requests\validationPurchase;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/*
🗒️NOTAS:
1: Devuelve el importe total actual de la compra
*/

class ProductPurchaseController extends Controller
{
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
  
    public function calculateTotalImport($purchaseId): float
    {
        $totalImport = ProductPurchase::where('purchase_id', $purchaseId)->sum('import');
        return $totalImport;
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

    // **Obtener las compras de productos ordenadas por id descendente**
    private function getSortedPurchasesById()
    {
        return ProductPurchase::orderBy('id', 'desc')->get();
    }

    // **Obtener productos ordenados por descripcion**
    private function getSortedProducts()
    {
        return Product::orderBy('description')->get();
    }

    // **Obtener todos los productos**
    private function getAllProducts()
    {
        return Product::all();
    }
}
