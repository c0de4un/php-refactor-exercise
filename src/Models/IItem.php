<?php

declare(strict_types=1);

namespace GildedRose\Models;

interface IItem extends IQuality, ISellable
{

    public function getName(): string;
    public function getType(): int;
    public function Update(): void;

}
