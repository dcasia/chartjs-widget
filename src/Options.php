<?php

namespace DigitalCreative\ChartJsWidget;

use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Laravel\Nova\Makeable;

/**
 * Class Datasets
 *
 * @see https://www.chartjs.org/docs/latest/charts/line.html#dataset-properties
 *
 * @method self backgroundColor($color)
 * @method self borderCapStyle(string $style = 'butt')
 * @method self borderColor($color)
 * @method self borderDashOffset(int $offset)
 * @method self borderDash(array $dash)
 * @method self borderJoinStyle(string $style = 'miter')
 * @method self borderWidth(int $width = 3)
 * @method self cubicInterpolationMode(string $interpolation = 'default')
 * @method self clip($option)
 * @method self fill($option) // possible values: int, origin, bool
 * @method self hoverBackgroundColor($color)
 * @method self hoverBorderCapStyle(string $style)
 * @method self hoverBorderColor($color)
 * @method self hoverBorderDash(array $dash)
 * @method self hoverBorderDashOffset(int $offset)
 * @method self hoverBorderJoinStyle(string $style)
 * @method self hoverBorderWidth(int $width)
 * @method self label(string $label)
 * @method self lineTension(float $tension = 0.4)
 * @method self order(number $order)
 * @method self pointBackgroundColor($color)
 * @method self pointBorderColor($color)
 * @method self pointBorderWidth(int $width = 1)
 * @method self pointHitRadius(int $radius = 1)
 * @method self pointHoverBackgroundColor($color)
 * @method self pointHoverBorderColor($color)
 * @method self pointHoverBorderWidth(int $width)
 * @method self pointHoverRadius(int $radius = 4)
 * @method self pointRadius(int $radius = 3)
 * @method self pointRotation(int $rotation = 0)
 * @method self pointStyle(string $style = 'circle')
 * @method self showLine(bool $show)
 * @method self spanGaps(bool $span)
 * @method self steppedLine(bool $stepped = false)
 *
 * @property array|null data
 * @package DigitalCreative\Options
 */
class Options extends Fluent
{
    use Makeable;

    /**
     * @param AbstractColor|string|array $color
     *
     * @return $this
     */
    public function color($color): self
    {
        return $this
//            ->backgroundColor($color)
//            ->hoverBackgroundColor($color)
            ->borderColor($color)
            ->hoverBorderColor($color)
            ->pointBackgroundColor($color)
            ->pointBorderColor($color)
            ->pointHoverBackgroundColor($color)
            ->pointHoverBorderColor($color);
    }

    public function clone(): self
    {
        return clone $this;
    }

    /**
     * Batch set options without passing params by params
     *
     * @param array|Options $data
     *
     * @return $this
     */
    public function apply($data): self
    {
        $this->attributes = array_merge($this->attributes, $data instanceof self ? $data->toArray() : $data);

        return $this;
    }

    public function jsonSerialize(): array
    {

        /**
         * Automatically casts the color presets into AbstractColor Objects
         */
        $colors = [
            'backgroundColor',
            'borderColor',
            'hoverBackgroundColor',
            'hoverBorderColor',
            'pointBackgroundColor',
            'pointBorderColor',
            'pointHoverBackgroundColor',
            'pointHoverBorderColor',
        ];

        foreach (Arr::only($this->attributes, $colors) as $attribute => $value) {

            if (is_array($value)) {

                if (Arr::isAssoc($value)) {

                    $lastValue = $value[ 'direction' ] ?? Gradient::HORIZONTAL;

                    unset($value[ 'direction' ]);

                } else if (is_numeric($value[ count($value) - 1 ])) {

                    /**
                     * If last value is numeric use that as the direction of the gradient
                     */
                    $lastValue = array_pop($value);

                } else {

                    $lastValue = Gradient::HORIZONTAL;

                }

                $this->$attribute = new Gradient($value, $lastValue);

            } else if (is_string($value)) {

                $this->$attribute = new Color($value);

            }

        }

        return parent::jsonSerialize();
    }

}
