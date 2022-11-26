<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('price', [$this, 'priceFilter']),
        ];
    }

    public function priceFilter($number): string
    {
        return '$' . number_format($number, 2);
    }
}