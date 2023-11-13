<?php

declare(strict_types=1);

namespace GildedRose\Models;

final class Sulfuras extends ItemModel
{
    public const NAME = 'Sulfuras, Hand of Ragnaros';

    public const QUALITY = 80;

    public function __construct(
        int $sellIn,
        int $quality,
        bool $isConjured = false,
    ) {
        parent::__construct(self::NAME, $sellIn, self::QUALITY, $isConjured);
    }

    protected function updateQuality(): void
    {
        // void
    }
}
