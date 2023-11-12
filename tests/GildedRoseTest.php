<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Models\IItem;
use GildedRose\Factories\ItemsFactory;
use GildedRose\Models\EItemTypes;
use PHPUnit\Framework\TestCase;

final class GildedRoseTest extends TestCase
{

    /**
     * @test
     * @return void
     */
    public function testFoo(): void
    {
        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(EItemTypes::REGULAR, 0, 0, false, 'foo'),
        ];

        $gildedRose = GildedRose::Build($items);
        $gildedRose->updateQuality();

        $this->assertSame('foo', $items[0]->getName());
    }

    /**
     * @test
     * @return void
     */
    public function testRegularItemSellInMin(): void
    {
        $maxSellIn = 1;

        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::REGULAR,
                $maxSellIn,
                $maxSellIn,
                false,
                'Regular Item'
            ),
        ];

        $gildedRose = GildedRose::Build($items);

        $maxDays = $maxSellIn + 1;
        for ($day = 0; $day < $maxDays; $day++) {
            $gildedRose->updateQuality();
        }

        /** @var IItem $item */
        $item = &$items[0];

        $this->assertEquals($item->getSellIn() >= 0, 'SellIn cannot be less then 0');
    }

    /**
     * @test
     * @return void
     */
    public function testRegularItemQualityMin(): void
    {
        $maxSellIn = 1;

        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::REGULAR,
                $maxSellIn,
                $maxSellIn,
                false,
                'Regular Item'
            ),
        ];

        $gildedRose = GildedRose::Build($items);

        $maxDays = $maxSellIn + 1;
        for ($day = 0; $day < $maxDays; $day++) {
            $gildedRose->updateQuality();
        }

        /** @var IItem $item */
        $item = &$items[0];

        $this->assertEquals($item->getQuality() >= 0, 'Quality cannot be less then 0');
    }

    /**
     * @test
     * @return void
     */
    public function testConjuredRegularItemQualityUpdate(): void
    {
        $maxSellIn = 8;

        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::REGULAR,
                $maxSellIn,
                $maxSellIn,
                true,
                'Regular Item'
            ),
        ];

        $gildedRose = GildedRose::Build($items);

        $maxDays = 2;
        for ($day = 0; $day < $maxDays; $day++) {
            $gildedRose->updateQuality();
        }

        /** @var IItem $item */
        $item = &$items[0];

        $this->assertEquals($item->getQuality() == 4, 'Conjured item quality update invalid logic');
    }

}
