<?php

namespace App\Http\Controllers;

use App\Http\Requests\validationPurchase;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductPurchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PurchaseController extends Controller
{
  // **Muestra la lista de compras**
  public function index()
  {
    $purchases = Purchase::orderBy('id', 'desc')->paginate();
    $purchases = Purchase::query()
      ->orderBy('id', 'desc') //ordena por 'id' de forma descendente
      ->when(request('search'), function ($query, $search) {/*nota5: Buscador*/
        return $query->where(function ($query) use ($search) {
          $this->applySearchFilter($query, $search);
        });
      })
      ->paginate(10) //Pagina los resultados mostrando 10 registros por pagina
      ->withQueryString(); //Conserva los resultados de la busqueda aunque el usuario se mueve a otra pagina

    $productsPurchases = $this->getSortedPurchasesById();

    return view('purchases.index', compact('purchases', 'productsPurchases'));
  }


  // **Filtra el tipo de dato recibido para hacer la consulta del buscador**
  private function applySearchFilter($query, $search)
  {
    // Verificar si el dato de búsqueda es numérico
    if (is_numeric($search)) {
      $query->where('id', 'like', $search);
    } elseif ($this->isValidDate($search)) {
      // Convertir fecha válida a formato Y-m-d y aplicar filtro en campo purchase_date
      $searchDate = Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
      $query->where('purchase_date', 'like', '%' . $searchDate . '%');
    } else {
      // Aplicar filtro en campo supermarket para que busqueda de tipo string
      $query->where('supermarket', 'like', '%' . $search . '%');
    }
  }
  /*Verifica el formato de fecha */
  private function isValidDate($date)
  {
    // Verificar si la fecha es valida con el formato d/m/Y
    $d = \DateTime::createFromFormat('d/m/Y', $date);
    return $d && $d->format('d/m/Y') === $date;
  }

  // **Crea una nueva compra en la BD y muestra la lista de compras**
  public function store(validationPurchase $request)
  {
    // Crea una nueva compra en la BD con los datos del formulario
    $createdPurchase = Purchase::create($request->all());

    return view('productPurchases.create')->with([
      'products'=> $this->getSortedProducts(),
     'sortedProducts'=> $this->getSortedProducts(), 
     'createdPurchase'=>$createdPurchase
    ]); //note 2

  }

  // **Elimina una compra en la BD y muestra la lista de compras**
  public function destroy(Purchase $purchase)
  {
    $purchase->delete(); // Elimina la compra de la BD

    // Redirige a la ruta 'purchases.index'
    return redirect()->route('purchases.index');
  }

  // **Muestra la vista de actualizacion de la compra seleccionada**
  public function edit(Purchase $purchase)
  {
    $purchase->purchase_date = $this->changeDateFormat($purchase->purchase_date);
    return view('purchases.edit', compact('purchase'));
  }

  // *Metodo auxiliar: Formatea la fecha a YYYY-MM-DD para que se visualice en el formulario de la vista
  private function changeDateFormat($textDate)
  {
    return Carbon::parse($textDate)->format('Y-m-d');
  }

  // **Actualiza la compra que se selecciono**
  public function update(validationPurchase $request, Purchase $purchase)
  {
    // Actualiza la compra con los datos del formulario
    $purchase->update($request->all());

    $purchase_id = $purchase->id;

    $totalImport = $this->getTotalImport($purchase_id);

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

  // **obtener el importe total de una compra**
  private function getTotalImport($purchase_id)
  {
    $productPurchaseController = new ProductPurchaseController();
    return $productPurchaseController->calculateTotalImport($purchase_id);
  }
}
