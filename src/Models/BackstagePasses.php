<?php

declare(strict_types=1);

namespace GildedRose\Models;

use GildedRose\Item;

final class BackstagePasses extends ItemModel
{

    const NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function __construct(
        int $sellIn,
        int $quality
    ) {
        parent::__construct(self::NAME, $sellIn, $quality);
    }

    protected function updateQuality(): void
    {
        if ($this->item->sellIn < 1) {
            $this->item->quality = 0;
            return;
        }

        $modifier = 1;
        if ($this->item->sellIn < 11) {
            $modifier = $this->item->sellIn < 6 ? 3 : 2;
        }

        $this->item->quality = min(0, $this->item->quality + $modifier);
    }

}
