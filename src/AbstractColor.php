<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget;

use JsonSerializable;
use OzdemirBurak\Iris\Color\Factory;

abstract class AbstractColor implements JsonSerializable
{
    abstract public function getColors(): array;

    abstract public function setColors(array $colors): void;

    public function opacity(float $amount): self
    {
        $clone = $this->clone();
        $colors = $clone->getColors();

        foreach ($colors as $index => $color) {
            $colors[ $index ] = (string) Factory::init($color)->toRgba()->alpha($amount);
        }

        $clone->setColors($colors);

        return $clone;
    }

    public function clone(): self
    {
        return clone $this;
    }
}
