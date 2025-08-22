<?php

namespace App\Models;

enum CustomCategoriesProducts: string
{
    case BOOTS = 'boots';
    public function getDiscount(): ?array
    {
        return match($this) {
            self::BOOTS => [
                'discountPercentage' => 0.30,
                'discountPercentageText'=>'30%'
            ],
            default => null,
        };
    }
}
