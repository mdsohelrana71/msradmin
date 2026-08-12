<?php

namespace App\Enums;

enum CategoryType: string
{
    case BLOG = 'blog';
    case PRODUCT = 'product';

    public function label(): string
    {
        return match ($this) {
            self::BLOG => 'Blog',
            self::PRODUCT => 'Product',
        };
    }
}