<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const DEFAULT_CURRENCY = "EUR";
    protected $table = 'products';
    use HasFactory;

    protected $fillable = [
        'sku',
        'category',
        'price',
    ];

    /**
     * Calculates the final price of a product after applying discounts.
     * - Products in the "boots" category apply for a 30% discount
     * - The product with SKU "000003" apply for a 15% discount.
     * - When multiple discounts collide, mut apply the greater
     * @return array
     */
    public function calculatePrice(): array
    {
        $originalPrice = $this->price;
        $finalPrice = $originalPrice;
        if ($customCategory = CustomCategoriesProducts::tryFrom($this->category)) {
            $customDiscount = $customCategory->getDiscount();
        } elseif ($customSKU = CustomSKUProducts::tryFrom($this->sku)) {
            $customDiscount = $customSKU->getDiscount();
        }
        if (isset($customDiscount)) {
            $discountAmount = $originalPrice * $customDiscount['discountPercentage'];
            $finalPrice = $finalPrice - $discountAmount;
            $discountPercentage = $customDiscount['discountPercentageText'];
        }
        return [
            "original" => $originalPrice,
            "final" => (int) $finalPrice,
            "discount_percentage" => $discountPercentage ?? null,
            "currency" => self::DEFAULT_CURRENCY,
        ];
    }

}
