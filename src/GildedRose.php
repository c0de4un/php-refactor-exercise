<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Models\IItem;

final class GildedRose
{
    private static ?GildedRose $instance = null;

    /**
     * @var array IItem[]
     */
    private array $items;

    /**
     * @param IItem[] $items
     */
    private function __construct(
        array $items
    ) {
        $this->items = $items;
    }

    public static function getInstance(): ?self
    {
        return self::$instance;
    }

    /**
     * @param  IItem[] $items
     */
    public static function Build(array $items): self
    {
        return self::$instance = new self($items);
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->Update();
        }
    }
}
