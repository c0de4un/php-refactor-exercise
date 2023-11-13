<?php

declare(strict_types=1);

namespace GildedRose\Models;

use Stringable;

interface IItem extends IQuality, ISellable, Stringable
{

    public function getName(): string;
    public function getType(): int;
    public function isConjured(): bool;
    public function Update(): void;

}
