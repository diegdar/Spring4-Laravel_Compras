{{-- 🗒️noteS:
1: nombre de la ruta que buscará en  routes\web.php.
2: crea un token oculto para que los usuarios no generen codigo malicioso antes de enviar el formulario.
3: como html no entiende el metodo 'PUT' hay que dejarlo como 'POST' en la lina del form y aqui poner 'PUT' para que laravel entienda que se enviara de esta forma.
4: solo se imprimira este error si hay un error de validacion: ‼️hay que poner dentro el nombre del input, en este caso es 'name', 'descripcion' o 'categoria'.
5: el metodo old() si el usuario cambio el dato original devolvera el primero de sus parametros, pero si no cambio nada devolvera el valor del objeto del registro(su segundo paremtro)  
    
    --}}

    @extends('layouts.navigationBar')

    @section('title', 'Editar Producto')
    
    @section('content')
        <h1 class="text-4xl	text-red-500 font-semibold text-center">Edicion del producto:</h1>
        {{-- note 1 --}}
        <form action="{{ route('products.update', $product->id) }}" method="post" class="my-5 mx-3 text-center">
            @csrf {{-- note 2 --}}
            @method('put'){{-- note 3 --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 items-center mb-5">
                <section class="sm:text-right mr-3">
                    <label class="text-xl text-blue-600 font-bold">
                        Descripcion producto:
                    </label>
                </section>
                <section class="text-center sm:text-left">
                    <input type="text" name="description" class="h-9 w-27"
                        value="{{ old('description', $product->description) }}" style="text-align: center">{{-- note 5 --}}
                </section>
                <section class="flex  sm:col-start-2  justify-center md:justify-start">
                    @error('description'){{-- note 4 --}}
                        <br>
                        <span class="textValidation">*{{ $message }}</span>
                        <br>
                    @enderror
                </section>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 items-center mb-5">
                <section class="sm:text-right mr-3">
                    <label class="text-xl text-blue-600 font-bold">
                        Unidad de medida:
                    </label>
                </section>
                <section class="text-center sm:text-left">
                    <select name="measurement_unit" id="measurement_unit" class='px-4 py-2 border border-blue-200 rounded'>
                        <option value="{{ old('measurement_unit', $product->measurement_unit) }}">{{ $product->measurement_unit }}</option>
                        <option value="Kilogramo">Kilogramo</option>
                        <option value="Gramo">Gramo</option>
                        <option value="Litro">Litro</option>
                        <option value="Unidad">Unidad</option>
                    </select>
                </section>
                <section class="flex  sm:col-start-2  justify-center md:justify-start">
                    @error('measurement_unit'){{-- note 2 --}}
                        <span class="textValidation">*{{ $message }}</span>
                    @enderror
                </section>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 items-center mb-5">
                <section class="sm:text-right mr-3">
                    <label class="text-xl text-blue-600 font-bold">
                        Categoria del producto:
                    </label>
                </section>
                <section class="text-center sm:text-left">
                    <select name="category" id="category" class='px-4 py-2 border border-blue-200 rounded'>
                        <option value="{{ old('category', $product->category) }}">{{ $product->category }}</option>
                        <option value="Alimentacion">Alimentacion</option>
                        <option value="Limpieza">Limpieza</option>
                        <option value="Higiene personal">Higiene personal</option>
                        <option value="Hogar">Hogar</option>
                    </select>
                </section>
                <section class="flex  sm:col-start-2  justify-center md:justify-start">
                    @error('category'){{-- note 2 --}}
                        <span class="textValidation">*{{ $message }}</span>
                    @enderror
                </section>
            </div>

            <button type="submit" class='bg-blue-600 text-white px-7 py-2 rounded hover:bg-blue-300 my-3'>Actualizar
                producto</button>
        </form>
    
    
    @endsection
    