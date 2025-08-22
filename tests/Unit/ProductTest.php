<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testCalculatePriceWhenProductHasCustomCategoryMustApplyDiscountOnPrice(): void
    {
        $product = Product::create([
            'sku' => 'NORM001',
            'category' => 'boots',
            'price' => 89000,
        ]);
        $this->assertEquals([
            "original" => 89000,
            "final" => 62300,
            "discount_percentage" => "30%",
            "currency" => "EUR",
        ], $product->calculatePrice());
    }

    public function testCalculatePriceWhenProductHasCustomSKUMustApplyDiscountOnPrice(): void
    {
        $product = Product::create([
            'sku' => '000003',
            'category' => 'shoes',
            'price' => 89000,
        ]);
        $this->assertEquals([
            "original" => 89000,
            "final" => 75650,
            "discount_percentage" => "15%",
            "currency" => "EUR",
        ], $product->calculatePrice());
    }

    public function testCalculatePriceWhenMultipleDiscountsCollideMustApplyTheGreaterOne(): void
    {
        $product = Product::create([
            'sku' => '000003',
            'category' => 'boots',
            'price' => 89000,
        ]);
        $this->assertEquals([
            "original" => 89000,
            "final" => 62300,
            "discount_percentage" => "30%",
            "currency" => "EUR",
        ], $product->calculatePrice());
    }
}
