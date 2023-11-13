<?php

declare(strict_types=1);

namespace GildedRose\Models;

final class AgedBrie extends ItemModel
{
    public const NAME = 'Aged Brie';

    public function __construct(
        int $sellIn,
        int $quality,
        bool $isConjured = false,
    ) {
        parent::__construct(self::NAME, $sellIn, $quality, $isConjured);
    }

    public function getType(): int
    {
        return EItemTypes::AGED_BRIE;
    }

    protected function updateQuality(): void
    {
        $modifier = $this->isConjured() ? 2 : 1;
        $this->item->quality = min(50, $this->item->quality + $modifier);
    }
}
