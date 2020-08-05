<?php

namespace DigitalCreative\ChartJsWidget;

class Color extends AbstractColor
{
    private string $color;

    /**
     * Color constructor.
     *
     * @param string $color
     */
    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function getColors(): array
    {
        return [ $this->color ];
    }

    public function setColors(array $colors): void
    {
        $this->color = $colors[ 0 ];
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => 'solid',
            'color' => $this->color,
        ];
    }
}
