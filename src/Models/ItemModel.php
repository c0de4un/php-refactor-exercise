<?php

declare(strict_types=1);

namespace GildedRose\Models;

use GildedRose\Item;

class ItemModel implements IItem
{

    protected Item $item;

    public function __construct(
        string $name,
        int $sellIn,
        int $quality,
        protected bool $conjured = false
    ) {
        assert(!empty($name));
        assert($sellIn >= 0);
        assert($quality >= 0);

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

    public final function Update(): void
    {
        $this->updateSellIn();
        $this->updateQuality();
    }

    public final function getName(): string
    {
        return $this->item->name;
    }

    public function getType(): int
    {
        return EItemTypes::REGULAR;
    }

    public final function isConjured(): bool
    {
        return $this->conjured;
    }

    protected function updateSellIn(): void
    {
        $this->item->sellIn = max(0, $this->item->sellIn - 1);
    }

    protected function updateQuality(): void
    {
        $modifier = $this->item->sellIn > 0 ? 1 : 2;
        if ($this->conjured) {
            $modifier *= 2;
        }

        $this->item->quality = max(0, $this->item->quality - $modifier);
    }

}
