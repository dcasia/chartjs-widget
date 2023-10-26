<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\Card\View;
use DigitalCreative\NovaDashboard\Card\Widget;
use Exception;
use Illuminate\Support\Collection;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class ChartJsWidget extends Widget
{
    public string $type;

    public $component = 'chart-widget';

    public function title(string $title): self
    {
        return $this->withMeta([ 'title' => $title ]);
    }

    public function buttonTitle(string $title): self
    {
        return $this->withMeta([ 'buttonTitle' => $title ]);
    }

    public function disableAnimation(): self
    {
        return $this->withMeta([ 'animation' => false ]);
    }

    public function disableLegend(): self
    {
        return $this->withMeta([ 'legend' => [ 'display' => false ] ]);
    }

    public function disableTooltip(): self
    {
        return $this->withMeta([ 'tooltip' => [ 'enabled' => false ] ]);
    }

    /**
     * @see https://www.chartjs.org/docs/latest/configuration/legend.html#legend
     */
    public function legend(array $options): self
    {
        $legend = $this->getMeta('legend', []);

        return $this->withMeta([ 'legend' => array_merge_recursive($legend, $options) ]);
    }

    /**
     * @see https://www.chartjs.org/docs/latest/axes/#axes
     */
    public function scales(array $options): self
    {
        $tooltip = $this->getMeta('scales', []);

        return $this->withMeta([ 'scales' => array_merge_recursive($tooltip, $options) ]);
    }

    /**
     * @see https://www.chartjs.org/docs/latest/configuration/tooltip.html#tooltip
     */
    public function tooltip(array $options): self
    {
        $tooltip = $this->getMeta('tooltip', []);

        return $this->withMeta([ 'tooltip' => array_merge_recursive($tooltip, $options) ]);
    }

    /**
     * @see https://www.chartjs.org/docs/latest/configuration/elements.html#elements
     */
    public function elements(
        ?array $point = null,
        ?array $line = null,
        ?array $bar = null,
        ?array $arc = null,
    ): self
    {
        $elements = $this->getMeta('elements', []);

        return $this->withMeta([
            'elements' => array_merge_recursive($elements, array_filter([
                'point' => $point,
                'line' => $line,
                'bar' => $bar,
                'arc' => $arc,
            ])),
        ]);
    }

    public function icon(?string $leadingIcon = null, ?string $trailingIcon = null): self
    {
        return $this->withMeta([ 'leadingIcon' => $leadingIcon, 'trailingIcon' => $trailingIcon ]);
    }

    public function padding(int $top, ?int $left = null, ?int $bottom = null, ?int $right = null): self
    {
        return $this->withMeta([
            'padding' => [
                'top' => $top,
                'left' => $left ?? $top,
                'bottom' => $bottom ?? $top,
                'right' => $right ?? $left ?? $top,
            ],
        ]);
    }

    public function addTab(string $widget): self
    {
        if (is_subclass_of($widget, static::class)) {
            throw new Exception('Please provide an class string of another ChartJs widget');
        }

        $tabs = $this->getMeta('tabs', []);

        $widget = new $widget($this->caller);

        return $this->withMeta([
            'tabs' => array_merge($tabs, [ $widget ]),
        ]);
    }

    public function resolveValue(NovaRequest $request, ?View $view = null): Collection
    {
        $value = parent::resolveValue($request, $view);

        $tabs = collect($this->getMeta('tabs'));
        $tabs = $tabs->flatMap(function (ChartJsWidget $widget) use ($request, $view) {

            $widget->configure($request);

            return $widget->resolveValue($request, $view);

        });

        $title = $this->getMeta('title') ?? $this->getMeta('buttonTitle');

        $tabs->prepend([
            'key' => $this->key(),
            'type' => $this->type,
            'title' => $title,
            'leadingIcon' => $this->getMeta('leadingIcon'),
            'trailingIcon' => $this->getMeta('trailingIcon'),
            'buttonTitle' => $this->getMeta('buttonTitle', $title),
            'padding' => $this->getMeta('padding', 10),
            'animation' => $this->getMeta('animation', true),
            'legend' => $this->getMeta('legend'),
            'tooltip' => $this->getMeta('tooltip'),
            'elements' => $this->getMeta('elements'),
            'scales' => $this->getMeta('scales'),
            'value' => $value,
        ]);

        foreach ($this->meta as $attribute => $_) {
            unset($this->meta[ $attribute ]);
        }

        return $tabs;
    }
}
