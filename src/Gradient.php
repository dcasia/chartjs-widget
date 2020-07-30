<?php

namespace DigitalCreative\ChartJsWidget;

class Gradient extends AbstractColor
{
    private array $colors;
    private int $direction;

    public const HORIZONTAL = 0;
    public const VERTICAL = 1;

    public const PURPLE_LOVE = [ '#cc2b5e', '#753a88' ];
    public const ORANGE = [ '#e65c00', '#F9D423' ];
    public const GRADE_GRAY = [ '#bdc3c7', '#2c3e50' ];
    public const AQUA_MARINE = [ '#1A2980', '#26D0CE' ];

    /**
     * Color constructor.
     *
     * @param array $colors
     * @param int $direction
     */
    public function __construct(array $colors, int $direction = Gradient::HORIZONTAL)
    {
        $this->colors = $colors;
        $this->direction = $direction;
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
