<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    private int $skuTotal = 1;
    private array $productCategories = [
        'boots',
        'shoes',
        'heels',
        'sneakers',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => $this->generateSku($this->skuTotal++, 6),
            'category' => $this->productCategories[array_rand($this->productCategories)],
            'price' => $this->faker->numberBetween(1, 200000),
        ];
    }
    private function generateSku(int $id, int $length = 6): string
    {
        return sprintf("%0{$length}d", $id);
    }
}
