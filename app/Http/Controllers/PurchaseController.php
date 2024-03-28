<?php

namespace App\Http\Controllers;

use App\Http\Requests\validationPurchase;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
/*
🗒️NOTES:
1: compact('compras'): es el array que recogemos en la variable $compras
2: Asignación masiva para insertar/actualizar registros: Crea una instancia de la clase Compra y pasará los valores recibidos en el formulario a los campos 'descripción', 'precio_unitario' y 'categoría' y también guardará estos registros en la base de datos internamente con el método save() por lo que es mejor que pasar los datos uno por uno manualmente.
      ⚠️para que funcione debes configurar un atributo con el nombre $fillable o $guarded en la Clase de Compra.
3: recogemos la Compra seleccionada para editar.
      pasa a la vista los campos de la Compra seleccionada.

4: Una vez realizada la acción del método, redirigimos al usuario a la lista de registros.
5: Ordene todos los productos alfabéticamente por descripción.
6: Necesitamos también que todos los productos sin clasificar por descripción coincidan con el 'id_product' y la posición en la matriz $products

*/

class PurchaseController extends Controller
{

    // Show the purchases list
    public function index()
    {

        $purchases = Purchase::orderBy('id', 'desc')->paginate(); //note 1
        // return $purchases;

        $productsPurchases = ProductPurchase::orderBy('id', 'desc')->get(); // Obtiene las compras ordenadas por id mostrando la mas reciente primero

        return view('purchases.index', compact('purchases', 'productsPurchases')); //note 2

    }

    // crea una nueva Compra en la BD y muestra la lista de Compras
    public function store(validationPurchase $request)
    {
        $createdPurchase = Purchase::create($request->all());
        // var_dump($createdPurchase);

        $sortedProducts = Product::orderBy('description')->get(); //note 5
        // return $sortedProducts;
        $products = Product::all(); //note 6

        return view('productPurchases.create', compact('products', 'sortedProducts', 'createdPurchase')); //note 2

    }

    // Elimina una Compra en la BD y muestra la lista de Compras
    public function destroy(Purchase $purchase)
    {

        $purchase->delete();

        return redirect()->route('purchases.index'); //note 4
    }

    // Muestra la vista de actualización de la Compra seleccionada
    public function edit(Purchase $purchase)
    { //note 3

        // Formatea la fecha a YYYY-MM-DD para que se visualice en el formulario de la vista
        $purchase->purchase_date = Carbon::parse($purchase->purchase_date)->format('Y-m-d');

        return view('purchases.edit', compact('purchase')); //note 3
    }

    // Actualiza la compra que se selecciono
    public function update(validationPurchase $request, Purchase $purchase)
    {

        $purchase->update($request->all()); //note 2

        // return $purchase;

        $purchase_id = $purchase->id;
        $purchase_date = $purchase->purchase_date;
        $supermarket = $purchase->supermarket;

        $sortedProducts = Product::orderBy('description')->get(); //note 5
        // return $sortedProducts;
        $products = Product::all(); //note 6

        $productsPurchases = ProductPurchase::orderBy('id', 'desc')->get();
        
        // Devuelve el importe total actual de la compra
        $productPurchaseController = new ProductPurchaseController();
        $totalImport = $productPurchaseController->getTotalImport($purchase_id);

        return view('productPurchases.create', compact(
            'products',
            'sortedProducts',
            'purchase_id',
            'purchase_date',
            'supermarket',
            'productsPurchases',
            'totalImport'
         )); //note 2
    }
}
