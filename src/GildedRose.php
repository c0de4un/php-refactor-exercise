<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Models\IItem;

final class GildedRose
{

    private static ?GildedRose $instance = null;

    /** @var array IItem[] */
    private array $items;

    /**
     * @param IItem[] $items
     */
    private function __construct(
        array $items
    ) {
        $this->items = $items;
    }

    public static function getInstance(): ?GildedRose
    {
        return self::$instance;
    }

    /**
     * @param  IItem[] $items
     * @return GildedRose
     */
    public static function Build(array $items): GildedRose
    {
        return self::$instance = new GildedRose($items);
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->Update();
        }
    }

}
