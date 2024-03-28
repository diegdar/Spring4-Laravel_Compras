<?php

namespace App\Http\Controllers;

use App\Http\Requests\validationPurchase;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
  // **Muestra la lista de compras**
  public function index()
  {
    $purchases = Purchase::orderBy('id', 'desc')->paginate();

    $productsPurchases = $this->getSortedPurchasesById();

    return view('purchases.index', compact('purchases', 'productsPurchases'));
  }

  // **Crea una nueva compra en la BD y muestra la lista de compras**
  public function store(validationPurchase $request)
  {
    // Crea una nueva compra en la BD con los datos del formulario
    $createdPurchase = Purchase::create($request->all());

    $sortedProducts = $this->getSortedProducts();
    $products = $this->getAllProducts();

    return view('productPurchases.create', compact('products', 'sortedProducts', 'createdPurchase'));
  }

  // **Elimina una compra en la BD y muestra la lista de compras**
  public function destroy(Purchase $purchase)
  {    
    $purchase->delete();// Elimina la compra de la BD

    // Redirige a la ruta 'purchases.index'
    return redirect()->route('purchases.index');
  }

  // **Muestra la vista de actualizacion de la compra seleccionada**
  public function edit(Purchase $purchase)
  {
    return view('purchases.edit', compact('purchase'));
  }

  // **Actualiza la compra que se selecciono**
  public function update(validationPurchase $request, Purchase $purchase)
  {
    // Actualiza la compra con los datos del formulario
    $purchase->update($request->all());

    $sortedProducts = $this->getSortedProducts();

    $purchase_id = $purchase->id;
    $products = $this->getAllProducts();
    $productsPurchases = $this->getSortedPurchasesById();

    // Obtiene el importe total de la compra
    $totalImport = $this->getTotalImport($purchase_id);

    return view('productPurchases.create', compact(
      'products',
      'sortedProducts',
      'purchase_id',
      'supermarket',
      'productsPurchases',
      'totalImport'
    ));
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

  // **obtener el importe total de una compra**
  private function getTotalImport($purchase_id)
  {
    $productPurchaseController = new ProductPurchaseController();
    return $productPurchaseController->getTotalImport($purchase_id);
  }
}
