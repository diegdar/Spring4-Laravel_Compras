<?php

namespace App\Http\Controllers;

use App\Http\Requests\validationProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/*
🗒️NOTES:
1: compact('productos'): es el array que recogemos en la variable $productos
2: Asignación masiva para insertar/actualizar registros: Crea una instancia de la clase de producto y pasará los valores recibidos en el formulario a los campos 'descripción', 'precio_unitario' y 'categoría' y también guardará estos registros en la base de datos internamente con el método save() por lo que es mejor que pasar los datos uno por uno manualmente.
      ⚠️para que funcione debes configurar un atributo con el nombre $fillable o $guarded en la Clase del producto.
3: recogemos el producto seleccionado para editar.
      pasa a la vista los campos del producto seleccionado.

4: Después de eliminarlo, se redirigirá al usuario a la lista de registros.
5: Busca en los campos de la tabla el texto introducido por el usuario en el caja de texto de busqueda en la vista.
*/

class ProductController extends Controller
{
    // Muestra la lista de productos
    public function index()
    {
        $products = Product::query()
            ->orderBy('id', 'desc')//ordena por 'id' de forma descendente
            ->when(request('search'), function ($query, $search) {
                return $query/*nota5: Buscador*/
                    ->where('description', 'like', '%' . $search . '%')
                    ->orWhere('measurement_unit', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            })->paginate(10)//Pagina los resultados mostrando 10 registros por pagina
            ->withQueryString();//Conserva los resultados de la busqueda aunque el usuario se mueve a otra pagina

        return view('products.index', compact('products'));
    }

    // Crea un nuevo producto en la BD y muestra la lisa de productos 
    public function store(validationProduct $request)
    {
        // return $request;

        Product::create($request->all()); //note 1

        $products = Product::orderBy('id', 'desc')->paginate(); //note 1
        return view('products.index', compact('products')); //note 2
    }

    // Borra un producto de la lista de productos
    public function destroy(Product $product)
    {

        // return $product;

        $product->delete();

        return redirect()->route('products.index'); //note 4
    }

    // Muestra la vista para editar el producto seleccionado
    public function edit(Product $product)
    { //note 3

        return view('products.edit', compact('product')); //note 3
    }

    // Actualiza el producto seleccionado
    public function update(validationProduct $request, Product $product)
    {
        // return $request;

        $product->update($request->all()); //note 2

        $products = Product::orderBy('id', 'desc')->paginate(); //note 1
        return Redirect::route('products.index')->with('products', $products);
    }
}
