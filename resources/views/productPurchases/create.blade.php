{{-- 
🗒️noteS:
1: crea un token oculto para que los usuarios no generen codigo malicioso antes de enviar el formulario.
2: mostrara un mensaje personalizado cuando no se cumpla la validacion del campo.
3: We have to subtract 1 unit to match the array position with the product_id      
    --}}
@extends('layouts.plantilla')

@section('title', 'Productos de la compra')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp


    {{-- Data insertion rows --}}
    <form action="{{ route('productPurchases.store') }}" method="POST" class="container mx-auto mt-5">
        @csrf{{-- note 1 --}}
        <div class="grid grid-cols-1 ">
            <article class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 my-4 gap-4">
                <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2 ">
                    <label for="purchase_id" class="text-right text-blue-600 font-bold">Compra Nº:</label>
                    <input type="text" class="mx-1 md:ml-2 text-center w-20" id="purchase_id"
                        value="{{ isset($createdPurchase->id) ? $createdPurchase->id : $purchase_id }}" readonly
                        name="purchase_id">
                </section>
                <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2">
                    <label for="purchase_date" class="text-right text-blue-600 font-bold">Fecha Compra:</label>
                    {{-- <div class='px-4 py-2 border border-blue-200 rounded'> --}}
                    <input type="date" class="mx-1 md:ml-2 text-center w-26"
                        value="{{ isset($createdPurchase->id) ? $createdPurchase->purchase_date : $purchase_date }}"
                        readonly>
                    {{-- </div> --}}
                </section>
                <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2">
                    <label for="supermarket" class="text-right text-blue-600 font-bold">Supermercado:</label>
                    <input type="text" class="mx-1 md:ml-2 text-center w-26" id="supermarket"
                        value="{{ isset($createdPurchase->id) ? $createdPurchase->supermarket : $supermarket }}" readonly
                        name="supermarket">
                </section>
                {{-- insert products --}}
                <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2">
                    <label for="product_id" class="text-right text-blue-600 font-bold">Producto:</label>
                    <select name="product_id" id="product_id" class="mx-1 md:ml-2 w-52">
                        <option value="--">--Elige un producto--</option>
                        @foreach ($sortedProducts as $productPurchase)
                            <option value="{{ $productPurchase->id }}">{{ $productPurchase->description }}</option>
                        @endforeach
                    </select>
                </section>
                <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2">
                    <label for="quantity" class="text-right text-blue-600 font-bold">Cantidad:</label>
                    <input type="number" name="quantity" class="mx-1 md:ml-2 text-center w-16" id="quantity"
                        min="1" max="100">
                </section>
                <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2 ">
                    <label for="unit_price" class="text-right text-blue-600 font-bold">Precio unitario:</label>
                    <input type="decimal" class="mx-1 md:ml-2 text-center w-20" name="unit_price" id="unit_price">
                </section>
            </article>
            <article>
                <section class='py-2 px-4 col-span-4 text-center'>
                    <input type='submit' value='Insertar producto' onclick="return validateProduct(event)"
                        class='bg-blue-600 text-white px-7 py-2 rounded hover:bg-blue-300'>
                </section>
            </article>
        </div>
    </form>
    @if (isset($totalImport) and $totalImport>0 ){{-- Solo muestra las cabeceras de la tabla si hay productos agregados a la compra (el importe de la compra es superior a 0)--}}
        <h1 class=" text-3xl md:text-5xl text-center text-red-500 my-4">
            Importe Total productos añadidos:
            <span class="text-6xl">{{ number_format(isset($totalImport) ? $totalImport : 0, 2, ',', '.') }}€</span>
        </h1>
        {{-- Tabla vista Desktop --------- --}}
        <div class="container mx-auto mt-5 tableDesktop">
            {{-- Products Table --}}
            <table class="w-full flex items-center justify-center flex-grow-0">
                {{-- Table header rows --}}
                <tr>
                    <th class="w-48">Ref. producto</th>
                    <th class="w-48">Descripcion</th>
                    <th class="w-48">Precio Unidad</th>
                    <th class="w-48">Cantidad</th>
                    <th class="w-48">Importe</th>
                    <th class="w-48">Unidad de medida</th>
                </tr>
    @endif
    {{-- List products already created --}}
    @if (isset($productsPurchases))
        @foreach ($productsPurchases as $productPurchase)
            @if ($productPurchase->purchase_id == $purchase_id)
                <tr class="rowsDesktop">
                    <td class="text-center">
                        {{ $productPurchase->product_id }}
                    </td>
                    <td class="text-center">
                        {{ $products[$productPurchase->product_id - 1]->description }}
                    </td>
                    <td class="text-center">
                        {{ number_format($productPurchase->unit_price, 2, ',', '.') }}€ {{-- nota 4 --}}
                    </td>
                    <td class="text-center">
                        {{ $productPurchase->quantity }}
                    </td>
                    <td class="text-center">
                        {{ number_format($productPurchase->import, 2, ',', '.') }}€ {{-- nota 4 --}}
                    </td>
                    <td class="text-center">
                        {{ $products[$productPurchase->product_id - 1]->measurement_unit }}
                    </td>
                    {{-- Delete button --}}
                    <td class="py-2 px-4">
                        <form action="{{ route('productPurchases.destroy', $productPurchase->id) }}" method="POST">
                            @csrf {{-- note 1 --}}
                            @method('delete') {{-- note 2 --}}
                            <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
                            <input type="hidden" name="purchase_date" value="{{ $purchase_date }}">
                            <input type="hidden" name="supermarket" value="{{ $supermarket }}">
                            <button type="submit" onclick="return confirmDelete('{{ $productPurchase->product_id }}')"
                                class="bg-red-500 text-white mt-4 px-8 py-2 rounded hover:bg-red-300">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endif
        @endforeach
    @endif
    </table>
    </div>
    {{-- Tabla vista Mobil -------------------------- --}}
    <div class="container mx-auto mt-5 tableMobile">
        {{-- Products Table --}}
        <table class="w-full flex items-center justify-center flex-grow-0">
            {{-- List products already created --}}
            @if (isset($productsPurchases))
                @foreach ($productsPurchases as $productPurchase)
                    @if ($productPurchase->purchase_id == $purchase_id)
                        <tr class="grid grid-cols-2">
                            <td class="headMobile">Ref. producto:</td>
                            <td class="text-left">
                                {{ $productPurchase->product_id }}
                            </td>
                        </tr>
                        <tr class="grid grid-cols-2">
                            <td class="headMobile">Descripcion:</td>
                            <td class="text-left">
                                {{ $products[$productPurchase->product_id - 1]->description }}
                            </td>
                        </tr>
                        <tr class="grid grid-cols-2">
                            <td class="headMobile">Precio Unidad:</td>
                            <td class="text-left">
                                {{ number_format($productPurchase->unit_price, 2, ',', '.') }}€ {{-- nota 4 --}}
                            </td>
                        </tr>
                        <tr class="grid grid-cols-2">
                            <td class="headMobile">Cantidad:</td>
                            <td class="text-left">
                                {{ $productPurchase->quantity }}
                            </td>
                        </tr>
                        <tr class="grid grid-cols-2">
                            <td class="headMobile">Importe:</td>
                            <td class="text-left">
                                {{ number_format($productPurchase->import, 2, ',', '.') }}€ {{-- nota 4 --}}
                            </td>
                        </tr>
                        <tr class="grid grid-cols-2">
                            <td class="headMobile">Unidad de medida:</td>
                            <td class="text-left">
                                {{ $products[$productPurchase->product_id - 1]->measurement_unit }}
                            </td>
                        </tr>
                        {{-- Delete button --}}
                        <td class="py-2 px-4 text-center">
                            <form action="{{ route('productPurchases.destroy', $productPurchase->id) }}" method="POST">
                                @csrf {{-- note 1 --}}
                                @method('delete') {{-- note 2 --}}
                                <input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
                                <input type="hidden" name="purchase_date" value="{{ $purchase_date }}">
                                <input type="hidden" name="supermarket" value="{{ $supermarket }}">
                                <button type="submit"
                                    onclick="return confirmDelete('{{ $productPurchase->product_id }}')"
                                    class="bg-red-500 text-white mt-4 px-8 py-2 rounded hover:bg-red-300">Borrar</button>
                            </form>
                        </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </table>
    </div>
@endsection

<script>
    function confirmDelete(product_id) {
        return confirm("¿Estás seguro de que deseas borrar el produtco con referencia Nº: " + product_id + "?");
    }

// Función para validar el precio unitario
function validateUnitPrice(unitPrice) {
  // Expresión regular para un número decimal positivo
  const unitPriceRegex = /^(\d+)(?:\,(\d{1,2})?)?$/;

  // Validar si el precio unitario es un número decimal
  if (!unitPriceRegex.test(unitPrice.trim())) {
    return false;
  }

  // Convertir el precio unitario a un número
  const parsedUnitPrice = parseFloat(unitPrice.replace(/,/g, '.'));

  // Validar si el precio unitario es mayor a 0
  if (parsedUnitPrice <= 0) {
    return false;
  }

  return true;
}

// Función para validar el producto
function validateProduct(event) {
  const product_id = document.getElementById('product_id').value;
  const quantity = document.getElementById('quantity').value;
  const unitPrice = document.getElementById('unit_price').value;

  // Validación de product_id
  if (product_id === '--') {
    alert('¡Debes elegir un producto!');
    event.preventDefault(); // Previene enviar el formulario
    return false;
  }

  // Validación de quantity (solo números enteros)
  const quantityRegex = /^\d+$/;
  if (!quantityRegex.test(quantity.trim())) {
    alert('¡La cantidad debe ser un número entero!');
    event.preventDefault(); // Previene enviar el formulario
    return false;
  }

  // Validación de unitPrice (solo números decimales)
  if (!validateUnitPrice(unitPrice.trim())) {
    alert('¡El precio unitario debe ser un número decimal positivo, y las posicion decimales se deben separar por una coma!');
    event.preventDefault(); // Previene enviar el formulario
    return false;
  }

  return true; // Envía el formulario si no hay errores de validación
}
</script>
