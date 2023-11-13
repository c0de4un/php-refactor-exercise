<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use GildedRose\GildedRose;
use GildedRose\Factories\ItemsFactory;
use GildedRose\Models\EItemTypes;
use GildedRose\Models\IItem;


echo 'OMGHAI!' . PHP_EOL;

/** @var IItem[] $items */
$items = [
    ItemsFactory::Create(EItemTypes::REGULAR, 10, 20, false, '+5 Dexterity Vest'),
    ItemsFactory::Create(EItemTypes::AGED_BRIE, 2, 0),
    ItemsFactory::Create(EItemTypes::REGULAR, 5, 7, false, 'Elixir of the Mongoose'),
    ItemsFactory::Create(EItemTypes::SULFURAS, -1, 80),
    ItemsFactory::Create(EItemTypes::SULFURAS, -1, 80),
    ItemsFactory::Create(EItemTypes::BACKSTAGE_PASSES, 15, 20),
    ItemsFactory::Create(EItemTypes::BACKSTAGE_PASSES, 10, 49),
    ItemsFactory::Create(EItemTypes::BACKSTAGE_PASSES, 5, 49),
    ItemsFactory::Create(EItemTypes::REGULAR, 3, 6, true, 'Conjured Mana Cake'),
];

$app = GildedRose::Build($items);

$days = 2;
if ((is_countable($argv) ? count($argv) : 0) > 1) {
    $days = (int) $argv[1];
}

for ($i = 0; $i < $days; $i++) {
    echo "-------- day ${i} --------" . PHP_EOL;
    echo 'name, sellIn, quality' . PHP_EOL;
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
    echo PHP_EOL;
    $app->updateQuality();
}
