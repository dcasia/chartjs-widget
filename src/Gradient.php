<?php

namespace DigitalCreative\ChartJsWidget;

class Gradient extends AbstractColor
{
    private array $colors;
    private int $direction;

    public const HORIZONTAL = 0;
    public const VERTICAL = 1;

    /**
     * Gradient constructor.
     *
     * @param array $colors
     * @param int $direction
     */
    public function __construct(array $colors, int $direction = Gradient::HORIZONTAL)
    {
        $this->colors = $colors;
        $this->direction = $direction;
    }

    public function getColors(): array
    {
        return $this->colors;
    }

    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => 'gradient',
            'direction' => $this->direction,
            'colors' => $this->colors,
        ];
    }
}
