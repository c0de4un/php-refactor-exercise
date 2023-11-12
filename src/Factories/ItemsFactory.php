<?php

declare(strict_types=1);

namespace GildedRose\Factories;

use GildedRose\Models\EItemTypes;
use GildedRose\Models\IItem;
use GildedRose\Models\ItemModel;
use GildedRose\Models\AgedBrie;
use GildedRose\Models\BackstagePasses;
use GildedRose\Models\Sulfuras;

final class ItemsFactory
{

    private static array $itemClassesByType = [
        EItemTypes::AGED_BRIE        => AgedBrie::class,
        EItemTypes::SULFURAS         => Sulfuras::class,
        EItemTypes::BACKSTAGE_PASSES => BackstagePasses::class,
    ];

    private function __construct()
    {
    }

    public static function Create(
        int $type,
        int $sellIn,
        int $quality,
        string $name = ''
    ): IItem {
        /** @var string|null $class */
        $class = self::$itemClassesByType[$type] ?? null;

        if ($class) {
            return new $class($sellIn, $quality);
        }

        return new ItemModel($name, $sellIn, $quality);
    }

}
