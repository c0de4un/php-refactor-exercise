<?php

declare(strict_types=1);

namespace GildedRose\Models;

interface IQuality
{

    public function getQuality(): int;
    public function updateQuality(): void;

}
