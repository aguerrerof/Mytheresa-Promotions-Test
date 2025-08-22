<?php

namespace App\Models;

enum CustomSKUProducts: string
{
    case SKU_0000003 = '000003';
    public function getDiscount(): ?array
    {
        return match($this) {
            self::SKU_0000003 => [
                'discountPercentage' => 0.15,
                'discountPercentageText'=>'15%'
            ],
            default => null,
        };
    }
}
