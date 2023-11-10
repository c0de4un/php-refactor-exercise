<?php

declare(strict_types=1);

namespace GildedRose\Models;

use GildedRose\Item;

class ItemModel implements IItem
{

    protected Item $item;

    protected function __construct(
        string $name,
        int $sellIn,
        int $quality
    ) {
        $this->item = new Item($name, $sellIn, $quality);
    }

    public final function getQuality(): int
    {
        return $this->item->quality;
    }

    public final function getSellIn(): int
    {
        return $this->item->sellIn;
    }

    public function updateQuality(): void
    {
    }

}
