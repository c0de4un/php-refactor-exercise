<?php

declare(strict_types=1);

namespace GildedRose\Models;

use GildedRose\Item;

abstract class ItemModel implements IItemModel
{

    protected Item $item;

    protected function __construct(
        string $name,
        int $sellIn,
        int $quality
    ) {
        $item = new Item($name, $sellIn, $quality);
    }

}
