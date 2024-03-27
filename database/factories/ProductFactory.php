<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => substr($this->faker->sentence(), 0, 40), // Limita a 40 los caracteres maximos
            'measurement_unit'=>$this->faker->randomElement(['Kg.','g.','L.','ud.']),/*nota 1*/
            'category'=>$this->faker->randomElement(['Alimentacion','Limpieza','Higiene personal','Hogar']),//Lo asigna de forma aleatoria entre los elementos del array dado
        ];
    }
}
