<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Factories\ItemsFactory;
use GildedRose\GildedRose;
use GildedRose\Models\EItemTypes;
use GildedRose\Models\IItem;
use GildedRose\Models\Sulfuras;
use PHPUnit\Framework\TestCase;

final class GildedRoseTest extends TestCase
{
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

        $this->assertEquals($item->getQuality() === 4, 'Conjured item quality update invalid logic');
    }


    public function testExpiredConjuredRegularItemQualityUpdate(): void
    {
        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::REGULAR,
                1,
                10,
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

        $this->assertEquals($item->getQuality() === 2, "Expired conjured item quality update invalid logic, expected 2, but got: {$item->getQuality()}");
    }


    public function testSulfurasQualityUpdate(): void
    {
        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::SULFURAS,
                1,
                1,
                true,
                'Regular Item'
            ),
        ];

        $gildedRose = GildedRose::Build($items);

        /** @var IItem $item */
        $item = &$items[0];

        $this->assertEquals($item->getQuality() === Sulfuras::QUALITY, 'Sulfuras must have constant quality value');

        $maxDays = 2;
        for ($day = 0; $day < $maxDays; $day++) {
            $gildedRose->updateQuality();
        }

        $this->assertEquals($item->getQuality() === Sulfuras::QUALITY, 'Sulfuras quality cannot be changed during update');
    }


    public function testAgedBrieQualityUpdate(): void
    {
        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::AGED_BRIE,
                1,
                1,
                false,
                'Regular Item'
            ),
        ];

        $gildedRose = GildedRose::Build($items);

        /** @var IItem $item */
        $item = &$items[0];

        $maxDays = 2;
        for ($day = 0; $day < $maxDays; $day++) {
            $gildedRose->updateQuality();
        }

        $this->assertEquals($item->getQuality() === 3, "Aged Brie invalid quality update logic, expected 3, but got: {$item->getQuality()}");
    }


    public function testConjuredAgedBrieQualityUpdate(): void
    {
        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::AGED_BRIE,
                1,
                1,
                true,
                'Regular Item'
            ),
        ];

        $gildedRose = GildedRose::Build($items);

        /** @var IItem $item */
        $item = &$items[0];

        $maxDays = 2;
        for ($day = 0; $day < $maxDays; $day++) {
            $gildedRose->updateQuality();
        }

        $this->assertEquals($item->getQuality() === 5, "Conjured Aged Brie invalid quality update logic, expected 3, but got: {$item->getQuality()}");
    }


    public function testBackstagePassesQualityUpdate(): void
    {
        /** @var IItem[] $items */
        $items = [
            ItemsFactory::Create(
                EItemTypes::BACKSTAGE_PASSES,
                11,
                1,
                false
            ),
            ItemsFactory::Create(
                EItemTypes::BACKSTAGE_PASSES,
                6,
                1,
                false
            ),
            ItemsFactory::Create(
                EItemTypes::BACKSTAGE_PASSES,
                1,
                1,
                false
            ),
        ];

        $gildedRose = GildedRose::Build($items);

        /** @var IItem $item */
        $item_10_sellIn = &$items[0];
        $item_5_sellIn = &$items[1];
        $item_expired = &$items[2];

        $maxDays = 1;
        for ($day = 0; $day < $maxDays; $day++) {
            $gildedRose->updateQuality();
        }

        $this->assertEquals($item_10_sellIn->getQuality() === 3, "Backstage passes, with sellin <= 10, invalid quality update, expected 3, got: {$item_10_sellIn->getQuality()}");
        $this->assertEquals($item_5_sellIn->getQuality() === 4, "Backstage passes, with sellin <= 5, invalid quality update, expected 4, got: {$item_5_sellIn->getQuality()}");
        $this->assertEquals($item_expired->getQuality() === 0, "Expired Backstage passes expected to have 0 quality, but got: {$item_expired->getQuality()}");
    }
}
