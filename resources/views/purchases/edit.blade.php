@extends('layouts.plantilla')

@section('title', 'Editar Compra')

@section('content')
  @php
    use Carbon\Carbon;
  @endphp

  <h1 class="text-5xl text-center text-red-500 my-4">Editar Compra Nº: {{ $purchase->id }}</h1>

  <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
    @csrf
    @method('put')

    <table class="w-full flex items-center justify-center flex-grow-0">
      <tr>
        <td class="w-1/4">
          <label for="purchase_date" class="text-xl text-blue-600 font-bold">Fecha Compra:</label>
        </td>
        <td class="w-3/4">
          <div class="px-4 py-2 border border-blue-200 rounded flex flex-col">
            <input type="date" style="text-align: center;"
                   value="{{ old('purchase_date', $purchase->purchase_date) }}"
                   name="purchase_date">
            @error('purchase_date')
              <span class="textValidation">*{{ $message }}</span>
            @enderror
          </div>
        </td>
      </tr>
      <tr>
        <td class="w-1/4">
          <label for="supermarket" class="text-xl text-blue-600 font-bold">Supermercado:</label>
        </td>
        <td class="w-3/4">
          <div class="px-4 py-2 border border-blue-200 rounded flex flex-col">
            <input type="text" style="text-align: center;"
                   value="{{ old('supermarket', $purchase->supermarket) }}"
                   name="supermarket">
            @error('supermarket')
              <span class="textValidation">*{{ $message }}</span>
            @enderror
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="text-center">
          <input type="submit" value="Guardar Cambios"
                  class="bg-blue-600 text-white px-7 py-2 rounded hover:bg-blue-300">
        </td>
      </tr>
    </table>
  </form>

@endsection

