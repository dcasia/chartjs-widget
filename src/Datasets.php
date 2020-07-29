<?php

namespace DigitalCreative\ChartWidget;

use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Laravel\Nova\Makeable;

/**
 * Class Datasets
 *
 * @see https://www.chartjs.org/docs/latest/charts/line.html#dataset-properties
 *
 * @method self borderCapStyle(string $style = 'butt')
 * @method self borderDashOffset(int $offset)
 * @method self borderDash(array $dash)
 * @method self borderJoinStyle(string $style = 'miter')
 * @method self borderWidth(int $width = 3)
 * @method self cubicInterpolationMode(string $interpolation = 'default')
 * @method self clip($option)
 * @method self fill(bool $useFill)
 * @method self hoverBorderCapStyle(string $style)
 * @method self hoverBorderDash(array $dash)
 * @method self hoverBorderDashOffset(int $offset)
 * @method self hoverBorderJoinStyle(string $style)
 * @method self hoverBorderWidth(int $width)
 * @method self label(string $label)
 * @method self lineTension(float $tension = 0.4)
 * @method self order(number $order)
 * @method self pointBorderWidth(int $width = 1)
 * @method self pointHitRadius(int $radius = 1)
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
 * @package DigitalCreative\ChartWidget
 */
class Datasets extends Fluent
{
    use Makeable;

    public function __construct(string $label, array $data)
    {

        $this->label($label);

        if (Arr::isAssoc($data)) {

            $this->data(array_values($data));

        } else {

            parent::__construct(compact('data'));

        }

    }

}
