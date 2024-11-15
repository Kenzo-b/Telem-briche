<?php

namespace App\twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
            new TwigFilter('dateFr', [$this, 'dateInFrenchFormat']),
        ];
    }

    public function formatPrice(int $priceInCents, int $decimals = 2): string {
        return number_format(($priceInCents/100), $decimals) . ' €';
    }

    public function dateInFrenchFormat(\DateTimeInterface $date): string {
        return date_format($date, 'd/m/Y');
    }

    public function getFunctions(): array {
        return [
            new TwigFunction('dateFr', [$this, 'dateInFrenchFormat']),
        ];
    }
}