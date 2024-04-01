<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function(Blueprint $table){
            $table->id();
            $table->string('description', 40);
            $table->string('measurement_unit', 15);
            $table->enum('category', ['Alimentacion','Limpieza','Higiene personal','Hogar']);
            $table->softDeletes();//crea la columna 'deleted_at' para conservar los valores de los productos agregados en compras anteriores al borrado del producto

            $table->timestamps();//crea las columnas created_at y updated_at para llevar un control de los registros

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }

    
};
