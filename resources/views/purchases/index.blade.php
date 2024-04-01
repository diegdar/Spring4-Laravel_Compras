{{-- 
🗒️noteS:
1: crea un token oculto para que los usuarios no generen codigo malicioso antes de enviar el formulario.
2: mostrara un mensaje personalizado cuando no se cumpla la validacion del campo.
3: We have to subtract 1 unit to match the array position with the product_id
4: Devuelve el importe total de la compra sumando todos los importes de los productos que la componen      
    --}}
@extends('layouts.plantilla')

@section('title', 'Lista Compras')

@section('content')
    @php
        use Carbon\Carbon;
        use App\Models\ProductPurchase;
    @endphp
    {{-- Boton subir a la parte de arriba del navegador --}}
    <div id="caja-flotante">
        <a href="#" onclick="scrollToTop()">Ir Arriba</a>
    </div>

    <form action="" class="text-center ml-auto mr-auto my-5 md:ml-40 md:my-5" method="GET">
        <div class="input-group mb-3">
            <button class="bg-green-600 text-white px-7 py-2 rounded hover:bg-blue-300" type="submit"
                id="button-addon2">Buscar</button>
            <input type="text" class="form-control h-9 p-2 w-3/4" placeholder="Escribir texto a buscar" name='search'>
        </div>
    </form>

    {{-- Tabla vista Desktop -------------------------- --}}
    <div class="tableDesktop">
        <table class="w-full flex items-center justify-center flex-grow-0">
            <tr>
                {{-- Data insertion Purchase rows --}}
                <form action="{{ route('purchases.store') }}" method="POST">
                    @csrf{{-- note 1 --}}
                    <td class='py-2 px-4'>
                        <input type='submit' value='Crear nueva Compra'
                            class='bg-blue-600 text-white px-7 py-2 rounded hover:bg-blue-300'>
                    </td>
                    <td>
                        <div class='px-4 py-2 border border-blue-200 rounded flex flex-col'>
                            <input type="date" class="h-9" name="purchase_date" style="text-align: center;">
                            @error('purchase_date')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </td>
                    <td>
                        <div class='px-4 py-2 border border-blue-200 rounded flex flex-col'>
                            <input type="text" class="h-9" name="supermarket" style="text-align: center;" placeholder="Ingresar supermercado">
                            @error('supermarket')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </td>
                </form>
            </tr>
            </form>
            {{-- Muestra mensaje cuando no hay resultado de busqueda --}}
            @if (!$purchases->count() > 0)
            <tr>
                <td class="text-4xl text-center text-red-500" colspan="4">No se encontraron compras para tus criterios de búsqueda!</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif

            @if ($purchases->isNotEmpty())
                {{-- Solo muestra las cabeceras de la tabla si hay compras creadas --}}
                <tr>
                    <td class="text-6xl text-center text-red-500" colspan="4">Compras hechas:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                {{-- Table header rows --}}
                <tr class="DesktopHead">
                    <th class="w-48">Nº Compra</th>
                    <th class="w-48">Fecha Compra</th>
                    <th class="w-48">Supermercado</th>
                    <th class="w-48">Importe Total</th>
                </tr>
            @endif
            {{-- Lista compras ya creadas --}}
            @foreach ($purchases as $purchase)
                @php
                    $totalImport = ProductPurchase::where('purchase_id', $purchase->id)->sum('import'); //nota 4
                @endphp
                <tr class="rowsDesktop">
                    <td class="text-center">
                        {{ $purchase->id }}
                    </td>
                    <td class="text-center">
                        {{ Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}
                    </td>
                    <td class="text-center">
                        {{ $purchase->supermarket }}
                    </td>
                    <td class="text-center">
                        {{ number_format($totalImport, 2, ',', '.') }}€ {{-- nota 4 --}}
                    </td>
                    {{-- Delete button --}}
                    <td class="px-4">
                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST">
                            @csrf{{-- note 1 --}}
                            @method('delete'){{-- note 2 --}}
                            <button type="submit" onclick="return confirmDelete('{{ $purchase->id }}')"
                                class='bg-red-500 text-white mt-4 px-8 py-2 rounded hover:bg-red-300'>Borrar</button>
                        </form>
                    </td class="px-4">
                    {{-- Update button --}}
                    <td>
                        <a href="{{ route('purchases.edit', $purchase->id) }}">
                            <input type='button' name='up' id='up' value='Editar'
                                class='bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-500'>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- Tabla vista Mobil -------------------------- --}}
    <div class="container mx-auto mt-5 tableMobile">
        <table class="w-full flex items-center justify-center flex-grow-0">
            {{-- Data insertion Purchase rows --}}
            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf{{-- note 1 --}}
                <article class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-4 gap-4">
                    <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2 items-center">
                        <label for="purchase_date" class="text-right mr-3 text-xl text-blue-600 font-bold">Compra
                            Nº:</label>
                        <input type="date" class="h-9" name="purchase_date" style="text-align: center;">
                        <div class="col-span-2 text-right">
                            @error('purchase_date')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </section>
                    <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2 items-center">
                        <label for="supermarket"
                            class="text-right mr-3 text-xl text-blue-600 font-bold">Supermercado:</label>
                        <input type="text" class="h-9" name="supermarket" style="text-align: center;">
                        <div class="col-span-2 text-right">
                            @error('supermarket')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </section>
                    <section class="mx-20 grid grid-cols-1 sm:grid-cols-1 md:m-auto md:col-span-2 items-center">
                        <input type='submit' value='Crear nueva Compra'
                            class='bg-blue-600 text-white px-7 py-2 rounded hover:bg-blue-300'>
                    </section>
                </article>
            </form>
            </tr>
            </form>
            {{-- Muestra mensaje cuando no hay resultado de busqueda --}}
            @if (!$purchases->count() > 0)
            <tr>
                <td class="text-4xl text-center text-red-500" colspan="4">No se encontraron compras para tus criterios de búsqueda!</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif

            {{-- Lista compras ya creadas --}}
            @if ($purchases->isNotEmpty()) {{-- Solo muestra las cabeceras de la tabla si hay compras creadas --}}
                <h1 class="text-6xl text-center text-red-500 my-4 " colspan="6">Compras hechas:</h1>
                @foreach ($purchases as $purchase)
                    @php
                        $totalImport = ProductPurchase::where('purchase_id', $purchase->id)->sum('import'); //nota 4
                    @endphp
                    <tr class="grid grid-cols-2">
                        <td class="headMobile">Nº Compra:</td>
                        <td class="text-center">
                            {{ $purchase->id }}
                        </td>
                    </tr>
                    <tr class="grid grid-cols-2">
                        <td class="headMobile">Fecha Compra:</td>
                        <td class="text-center">
                            {{ Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr class="grid grid-cols-2">
                        <td class="headMobile">Supermercado:</td>
                        <td class="text-center">
                            {{ $purchase->supermarket }}
                        </td>
                    </tr>
                    <tr class="grid grid-cols-2">
                        <td class="headMobile">Importe Total:</td>
                        <td class="text-center">
                            {{ number_format($totalImport, 2, ',', '.') }}€ {{-- nota 4 --}}
                        </td>
                    </tr>
                    <tr class="grid grid-cols-2 text-center mb-10">
                        {{-- Delete button --}}
                        <td class="px-4">
                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST">
                                @csrf{{-- note 1 --}}
                                @method('delete'){{-- note 2 --}}
                                <button type="submit" onclick="return confirmDelete('{{ $purchase->id }}')"
                                    class='bg-red-500 text-white mt-4 px-8 py-2 rounded hover:bg-red-300'>Borrar</button>
                            </form>
                        </td class="px-4">
                        {{-- Update button --}}
                        <td>
                            <a href="{{ route('purchases.edit', $purchase->id) }}">
                                <input type='button' name='up' id='up' value='Editar'
                                    class='bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-500'>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif

        </table>
    </div>
    <section class="flex justify-center">
        {{ $purchases->links() }}
    </section>
@endsection


<script>
    function confirmDelete(id_purchase) {
        return confirm("¿Estás seguro de que deseas borrar la compra Nº: " + id_purchase + "?");
    }
</script>
