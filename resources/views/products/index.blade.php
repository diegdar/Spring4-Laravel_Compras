{{-- 
🗒️noteS:
1: crea un token oculto para que los usuarios no generen codigo malicioso antes de enviar el formulario.
2: mostrara un mensaje personalizado cuando no se cumpla la validacion del campo    
    --}}
@extends('layouts.plantilla')

@section('title', 'Productos')

@section('content')
    {{-- Boton subir a la parte de arriba del navegador --}}
    <div id="caja-flotante">
        <a href="#" onclick="scrollToTop()">Ir Arriba</a>
    </div>

    {{-- Tabla vista Desktop -------------------------- --}}
    <div class="tableDesktop">
        <table class="flex items-center justify-center">
            {{-- Table header rows --}}
            <tr class="DesktopHead">
                <th>Ref. Producto</th>
                <th>Descripcion Producto</th>
                <th>Unidad de medida</th>
                <th>Categoria</th>
            </tr>
            <tr>
                {{-- Data insertion rows --}}
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf{{-- note 1 --}}
                    <td class='py-2 px-4'><input type='submit' value='Crear nuevo Producto'
                            class='bg-blue-600 text-white px-7 py-2 rounded hover:bg-blue-300'>
                    </td>

                    <td>
                        <div class='px-4 py-2 border border-blue-200 rounded flex flex-col'>
                            <input type="text" class="h-9" name="description" style="text-align: center;"
                                value="{{ old('description') }}">
                            @error('description')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </td>
                    <td>
                        <div class='px-4 py-2 border border-blue-200 rounded flex flex-col'>
                            <select name="measurement_unit" id="measurement_unit"
                                class='px-4 py-2 border border-blue-200 rounded'>
                                <option value="--">--Escoje un valor--</option>
                                <option value="Kilogramo" {{ old('measurement_unit') === 'Kilogramo' ? 'selected' : '' }}>
                                    Kilogramo
                                </option>
                                <option value="Gramo" {{ old('measurement_unit') === 'Gramo' ? 'selected' : '' }}>Gramo
                                </option>
                                <option value="Litro" {{ old('measurement_unit') === 'Litro' ? 'selected' : '' }}>
                                    Litro
                                </option>
                                <option value="Unidad" {{ old('measurement_unit') === 'Unidad' ? 'selected' : '' }}>Unidad
                                </option>
                            </select>
                            @error('measurement_unit')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </td>
                    <td>
                        <div class='px-4 py-2 border border-blue-200 rounded flex flex-col'>
                            <select name="category" id="category" class='px-4 py-2 border border-blue-200 rounded'>
                                <option value="--">--Escoje un valor--</option>
                                <option value="Alimentacion" {{ old('category') === 'Alimentacion' ? 'selected' : '' }}>
                                    Alimentacion
                                </option>
                                <option value="Limpieza" {{ old('category') === 'Limpieza' ? 'selected' : '' }}>Limpieza
                                </option>
                                <option value="Higiene personal"
                                    {{ old('category') === 'Higiene personal' ? 'selected' : '' }}>
                                    Higiene personal
                                </option>
                                <option value="Hogar" {{ old('category') === 'Hogar' ? 'selected' : '' }}>Hogar</option>
                            </select>
                            @error('category')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </td>
                </form>
            </tr>
            <tr>
                <td class="text-6xl text-center text-red-500" colspan="6">Lista de Productos Creados:</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            {{-- Lista de productos ya creados --}}
            @foreach ($products as $product)
                <tr class="rowsDesktop">
                    <td class="text-center">
                        {{ $product->id }}
                    </td>
                    <td class="text-center">
                        {{ $product->description }}
                    </td>
                    <td class="text-center">
                        {{ $product->measurement_unit }}
                    </td>
                    <td class="text-center">
                        {{ $product->category }}
                    </td>
                    {{-- Delete button --}}
                    <td class="py-2 px-4">
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="text-center">
                            @csrf{{-- note 1 --}}
                            @method('delete'){{-- note 2 --}}
                            <button type="submit" onclick="return confirmDelete('{{ $product->id }}')"
                                class='bg-red-500 text-white mt-4 px-8 py-2 rounded hover:bg-red-300'>Borrar</button>
                        </form>
                    </td class="py-2 px-4">
                    {{-- Update button --}}
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}">
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
            {{-- Data insertion product rows --}}
            <form action="{{ route('products.store') }}" method="POST">
                @csrf{{-- note 1 --}}
                <article class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-4 gap-4">
                    <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2 items-center">
                        <label for="description"
                            class="text-right mr-3 text-xl text-blue-600 font-bold">Descripcion:</label>
                        <input type="text" class="h-9" name="product_date" style="text-align: center;"
                            value="{{ old('description') }}">
                        <div class="col-span-2 text-right">
                            @error('description')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </section>
                    <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2 items-center">
                        <label for="measurement_unit" class="text-right mr-3 text-xl text-blue-600 font-bold">Unidad de
                            medida:</label>
                        <select name="measurement_unit" id="measurement_unit"
                            class='px-4 py-2 border border-blue-200 rounded'>
                            <option value="--">--Escoje un valor--</option>
                            <option value="Kilogramo" {{ old('measurement_unit') === 'Kilogramo' ? 'selected' : '' }}>
                                Kilogramo
                            </option>
                            <option value="Gramo" {{ old('measurement_unit') === 'Gramo' ? 'selected' : '' }}>Gramo
                            </option>
                            <option value="Litro" {{ old('measurement_unit') === 'Litro' ? 'selected' : '' }}>
                                Litro
                            </option>
                            <option value="Unidad" {{ old('measurement_unit') === 'Unidad' ? 'selected' : '' }}>Unidad
                            </option>
                        </select>
                        <div class="col-span-2 text-right">
                            @error('measurement_unit')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </section>
                    <section class="mx-20 md:m-auto grid grid-cols-2 sm:grid-cols-2 items-center">
                        <label for="category" class="text-right mr-3 text-xl text-blue-600 font-bold">Categoria:</label>
                        <select name="category" id="category" class='px-4 py-2 border border-blue-200 rounded'>
                            <option value="--">--Escoje un valor--</option>
                            <option value="Alimentacion" {{ old('category') === 'Alimentacion' ? 'selected' : '' }}>
                                Alimentacion
                            </option>
                            <option value="Limpieza" {{ old('category') === 'Limpieza' ? 'selected' : '' }}>Limpieza
                            </option>
                            <option value="Higiene personal"
                                {{ old('category') === 'Higiene personal' ? 'selected' : '' }}>
                                Higiene personal
                            </option>
                            <option value="Hogar" {{ old('category') === 'Hogar' ? 'selected' : '' }}>Hogar</option>
                        </select>
                        <div class="col-span-2 text-right">
                            @error('category')
                                {{-- note 2 --}}
                                <span class="textValidation">*{{ $message }}</span>
                            @enderror
                        </div>
                    </section>


                    <section class="mx-20 grid grid-cols-1 sm:grid-cols-1 md:m-auto  items-center">
                        <input type='submit' value='Crear nuevo Producto'
                            class='bg-blue-600 text-white px-7 py-2 rounded hover:bg-blue-300'>
                    </section>
                </article>
            </form>
            </tr>
            </form>
            {{-- Lista compras ya creadas --}}
            <h1 class="text-6xl text-center text-red-500 my-4 " colspan="6">Lista Productos creados:</h1>
            @foreach ($products as $product)
                <tr class="grid grid-cols-2">
                    <td class="headMobile">Ref. Producto:</td>
                    <td class="text-center">
                        {{ $product->id }}
                    </td>
                </tr>
                <tr class="grid grid-cols-2">
                    <td class="headMobile">Descripcion Producto:</td>
                    <td class="text-center">
                        {{ $product->description }}
                    </td>
                </tr>
                <tr class="grid grid-cols-2">
                    <td class="headMobile">Unidad de medida:</td>
                    <td class="text-center">
                        {{ $product->measurement_unit }}
                    </td>
                </tr>
                <tr class="grid grid-cols-2">
                    <td class="headMobile">Categoria:</td>
                    <td class="text-center">
                        {{ $product->category }}
                    </td>
                </tr>
                <tr class="grid grid-cols-2 text-center mb-10">
                    {{-- Delete button --}}
                    <td class="px-4">
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf{{-- note 1 --}}
                            @method('delete'){{-- note 2 --}}
                            <button type="submit" onclick="return confirmDelete('{{ $product->id }}')"
                                class='bg-red-500 text-white mt-4 px-8 py-2 rounded hover:bg-red-300'>Borrar</button>
                        </form>
                    </td class="px-4">
                    {{-- Update button --}}
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}">
                            <input type='button' name='up' id='up' value='Editar'
                                class='bg-yellow-700 text-white px-4 py-2 rounded hover:bg-yellow-500'>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <section class="flex justify-center">
        {{ $products->links() }}
    </section>
@endsection

<script>
    function confirmDelete(idProduct) {
        return confirm("¿Estás seguro de que deseas borrar con la referencia Nº: " + idProduct + "?");
    }
</script>
