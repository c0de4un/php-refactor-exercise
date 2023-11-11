<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Models\IItem;
use GildedRose\Factories\ItemsFactory;
use GildedRose\Models\EItemTypes;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(EItemTypes::REGULAR, 0, 0, 'foo'),
        ];

        $gildedRose = GildedRose::Build($items);
        $gildedRose->updateQuality();

        $this->assertSame('foo', $items[0]->getName());
    }
}
