<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListProductsEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function testMustReturnCorrectPaginationInformation(): void
    {
        $this->createProduct(
            4345,
            '000001',
            'boots',
            1000,
        );
        $response = $this->getJson('/api/products');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
            'products',
            'total',
            'per_page',
            'current_page',
            'last_page',
        ]);
    }

    public function testCategoryFilterMustReturnNewPrice(): void
    {
        $this->createProduct(
            1343,
            '000001',
            'boots',
            1000,
        );
        $this->createProduct(
            454655,
            '000002',
            'shoes',
            1000,
        );
        $this->createProduct(
            5656,
            '000003',
            'shoes',
            2000,
        );
        $response = $this->getJson('/api/products?category=shoes');
        $products = $response->json()['products'];
        $this->assertEquals(2, count($products));
        $this->assertEquals([
            [
                'id' =>5656,
                'sku' =>'000003',
                'category' => 'shoes',
                'price' => 1700,
            ],
            [
                'id' =>454655,
                'sku' =>'000002',
                'category' => 'shoes',
                'price' => 1000,
            ],
        ],$products);
    }

    public function testPriceLessThanFilter(): void
    {
        $this->createProduct(
            1343,
            '000001',
            'boots',
            1000,
        );
        $this->createProduct(
            454655,
            '000002',
            'shoes',
            1000,
        );
        $this->createProduct(
            5656,
            '000003',
            'shoes',
            2000,
        );
        $response = $this->getJson('/api/products?price_less_than=1099');
        $products = $response->json()['products'];
        $this->assertEquals(2, count($products));
        $this->assertEquals([
            [
                'id' =>1343,
                'sku' =>'000001',
                'category' => 'boots',
                'price' => 700,
            ],
            [
                'id' =>454655,
                'sku' =>'000002',
                'category' => 'shoes',
                'price' => 1000,
            ],
        ],$products);
    }

    /**
     * @param int $id
     * @param string $sku
     * @param string $category
     * @param int $price
     * @return void
     */
    public function createProduct(
        int $id,
        string $sku,
        string $category,
        int $price,
    ): void
    {
        Product::factory()->create([
            'id'=> $id,
            'sku' => $sku,
            'category' => $category,
            'price' => $price,
        ]);
    }
}
