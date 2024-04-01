<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/*
🗒️NOTAS:
1: si se elimina un producto en la tabla 'products' desaparecera tambien los registros de este en la tabla 'product_purchases'.
2: Si se actualiza un 'products' en la tabla products se vera la actualizacion en la tabla 'product_purchases'
*/
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2)->default(0); // Indica que los digitos total sean 8, 2 sean en la parte decimal y que tenga 0 como valor por defecto
            $table->decimal('import');

            $table->foreignId('product_id')
            ->constrained('products')
            ->onDelete('cascade')/*nota 1*/
            ->onUpdate('cascade');/*nota 2*/
        
            $table->foreignId('purchase_id')
                ->constrained('purchases')
                ->onDelete('cascade')/*nota 1*/
                ->onUpdate('cascade');/*nota 2*/
                
            $table->timestamps();

            // Al indexar el rendimiento es más rápido al realizar consultas
            $table->index('product_id');
            $table->index('purchase_id');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_purchases');
    }
};
