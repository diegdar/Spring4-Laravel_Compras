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

*/

class ProductController extends Controller
{
    // Muestra la lista de productos
    public function index(){

        $products = Product::orderBy('id', 'desc')->paginate(); //note 1
        return view('products.index', compact('products'));//note 2

        // return $products;
    }

    // Crea un nuevo producto en la BD y muestra la lisa de productos 
    public function store(validationProduct $request){
        // return $request;

        Product::create($request->all());//note 1

        $products = Product::orderBy('id', 'desc')->paginate(); //note 1
        return view('products.index', compact('products'));//note 2
    }

    // Borra un producto de la lista de productos
    public function destroy(Product $product){

        // return $product;

        $product->delete();

        return redirect()->route('products.index');//note 4
    }

    // Muestra la vista para editar el producto seleccionado
    public function edit( Product $product){//note 3
        
        return view('products.edit', compact('product')); //note 3
    }

    // Actualiza el producto seleccionado
    public function update(validationProduct $request, Product $product){
        // return $request;

        $product->update($request->all()); //note 2

        $products = Product::orderBy('id', 'desc')->paginate(); //note 1
        return Redirect::route('products.index')->with('products', $products);

    }

}
