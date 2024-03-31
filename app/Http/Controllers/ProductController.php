<?php

namespace App\Http\Controllers;

use App\Http\Requests\validationProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/*
NOTAS:
1: Pagina los resultados obtenidos, mostrando 10 registros por pagina.
2: Seguira mostrando los resultados del filtrado si hubo una busqueda aunque el usuario se mueva a otra pagina de la paginacion.
3: Asignación masiva para insertar/actualizar registros: Crea una instancia de la clase de producto y pasará los valores recibidos en el formulario a los campos 'descripción', 'precio_unitario' y 'categoría' y también guardará estos registros en la base de datos internamente con el método save() por lo que es mejor que pasar los datos uno por uno manualmente.
      ⚠️para que funcione debes configurar un atributo con el nombre $fillable o $guarded en la Clase del producto.

*/

class ProductController extends Controller
{
    // Muestra la lista de productos
    public function index()
    {
        $products = $this->getProducts(request('search'));
        return view('products.index', compact('products'));
    }
    //*Funcion auxiliar: Obtiene los productos, incluso si hay filtrado por medio del cuadro de busqueda
    private function getProducts($search = null)
    {
        $query = Product::query()->orderBy('id', 'desc');
    
        if ($search) {//filtra los resultados si el usuario ha introducido algun texto en el cuadro de busqueda
            $query->where(function ($query) use ($search) {
                $query->where('id', 'like', $search)
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('measurement_unit', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }
    
        return $query->paginate(10)/*nota 1*/->withQueryString()/*nota 2*/;
    }
    

    // Crea un nuevo producto en la BD y muestra la lisa de productos 
    public function store(validationProduct $request)
    {
        // return $request;

        Product::create($request->all()); //nota 3

        $products = Product::orderBy('id', 'desc')->paginate(); 
        return view('products.index', compact('products'));
    }

    // Borra un producto de la lista de productos
    public function destroy(Product $product)
    {

        // return $product;

        $product->delete();

        return redirect()->route('products.index'); 
    }

    // Muestra la vista para editar el producto seleccionado
    public function edit(Product $product)
    { 

        return view('products.edit', compact('product')); 
    }

    // Actualiza el producto seleccionado
    public function update(validationProduct $request, Product $product)
    {
        // return $request;

        $product->update($request->all()); //nota 3

        $products = Product::orderBy('id', 'desc')->paginate(10)/*nota 1*/; 
        return Redirect::route('products.index')->with('products', $products);
    }
}
