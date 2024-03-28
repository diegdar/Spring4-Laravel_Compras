<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPurchase>
 */
class ProductPurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->randomNumber(1, 10);
        $unitPrice = $this->faker->randomFloat(2, 0.1, 30);
            
        $productId = Product::inRandomOrder()->first()->id;
        $purchaseId = Purchase::inRandomOrder()->first()->id;            

        return [
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'import' => $quantity * $unitPrice,
            'product_id' => $productId,
            'purchase_id' => $purchaseId,
        ];
    }
}

