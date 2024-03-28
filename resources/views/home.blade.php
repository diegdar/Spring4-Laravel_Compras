@extends('layouts.plantilla')

@section('title', 'Home')

@section('content')
<h1 class="text-6xl	text-red-500 font-semibold text-center m-5">Gestiona tus compras en supermercados</h1>
<div class="bg-white shadow-md rounded-md p-4">
  
    <p class="text-gray-700 leading-relaxed">
      Esta aplicación web te permite gestionar dos aspectos importantes de un supermercado:
    </p>
  
    <ul class="list-disc mt-4 ml-4">
      <li>
        <h2 class="text-3xl">**Catálogo de productos:**</h2>
        <ul>
          <li>Registro de productos: Crea una base de datos completa con todos los productos que se venden en tu supermercado.</li>
          <li>Mantenimiento del catálogo: Edita, actualiza o elimina productos según sea necesario. Mantén tu inventario actualizado y preciso.</li>
        </ul>
      </li>
      <li>
        <h2 class="text-3xl">**Registro de compras:**</h2>
        <ul>
          <li>Registro de compras: Anota cada compra realizada en el supermercado, incluyendo la fecha, cantidad, producto, supermercado y el importe total.</li>
          <li>Análisis de compras: Obtén información valiosa sobre tus compras. Visualiza el historial de compras, identifica productos populares, compara precios por supermercado y mucho más.</li>
        </ul>
      </li>
    </ul>
  
    <h3 class="text-lg font-bold mt-6">Funcionalidades:</h3>
  
    <ul class="list-disc mt-4 ml-4">
      <li>CRUD completo: Crea, edita, actualiza y elimina registros en ambos módulos (productos y compras).</li>
      <li>Interfaz intuitiva: Diseño sencillo y fácil de usar para una gestión eficiente.</li>
      <li>Búsqueda y filtrado: Encuentra rápidamente la información que necesitas en ambos módulos.</li>
      <li>Informes y análisis: Obtén información valiosa sobre tus productos y compras.</li>
    </ul>
  
    <h3 class="text-lg font-bold mt-6">Beneficios:</h3>
  
    <ul class="list-disc mt-4 ml-4">
      <li>Mejora la gestión del inventario: Mantén un control preciso de los productos disponibles en tu supermercado.</li>
      <li>Agiliza el proceso de compra: Registra las compras de forma rápida y eficiente.</li>
      <li>Toma decisiones estratégicas: Obtén información valiosa para optimizar tu negocio.</li>
    </ul>
  
    <h3 class="text-lg font-bold mt-6">Ideal para:</h3>
  
    <ul class="list-disc mt-4 ml-4">
      <li>Propietarios de supermercados</li>
      <li>Gerentes de compras</li>
      <li>Personal de inventario</li>
      <li>Cualquier persona que quiera tener un mejor control de sus compras y productos.</li>
    </ul>
  
    <p class="text-center mt-6">
      <strong>¡Empieza a gestionar tu supermercado de forma más eficiente hoy mismo!</strong>
    </p>
  
  </div>
  
@endsection