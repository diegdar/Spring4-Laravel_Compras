<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supermarket'=>$this->faker->randomElement(['Lidl','Mercadona','Aldi','Caprabo','Dia']),//Lo asigna de forma aleatoria entre los elementos del array dado
        ];
    }
}
