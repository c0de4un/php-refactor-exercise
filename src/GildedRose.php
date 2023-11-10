<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {

        foreach ($this->items as $item) {
            $isBackstagePasses = $item->name === 'Backstage passes to a TAFKAL80ETC concert';
            $isAgedBrie = $item->name === 'Aged Brie';
            $isSulfuras = $item->name === 'Sulfuras, Hand of Ragnaros';

            if (!$isAgedBrie and !$isBackstagePasses) {
                if ($item->quality > 0) {
                    if (!$isSulfuras) {
                        $item->quality--;
                    }
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                    if ($isBackstagePasses) {
                        if ($item->sellIn < 11) {
                            if ($item->quality < 50) {
                                $item->quality++;
                            }
                        }
                        if ($item->sellIn < 6) {
                            if ($item->quality < 50) {
                                $item->quality++;
                            }
                        }
                    }
                }
            }

            if (!$isSulfuras) {
                $item->sellIn--;
            }

            if ($item->sellIn < 0) {
                if (!$isAgedBrie) {
                    if (!$isBackstagePasses) {
                        if ($item->quality > 0) {
                            if (!$isSulfuras) {
                                $item->quality--;
                            }
                        }
                    } else {
                        $item->quality--;
                    }
                } else {
                    if ($item->quality < 50) {
                        $item->quality++;
                    }
                }
            }
        }
    }
}
