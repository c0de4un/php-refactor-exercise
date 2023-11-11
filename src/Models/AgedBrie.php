<?php

declare(strict_types=1);

namespace GildedRose\Models;

use GildedRose\Item;

final class AgedBrie extends ItemModel
{

    const NAME = 'Aged Brie';

    public function __construct(
        int $sellIn,
        int $quality
    ) {
        parent::__construct(self::NAME, $sellIn, $quality);
    }

    public function getType(): int
    {
        return EItemTypes::AGED_BRIE;
    }

    protected function updateQuality(): void
    {
        $this->item->quality = min(50, $this->item->quality + 1);
    }

}
