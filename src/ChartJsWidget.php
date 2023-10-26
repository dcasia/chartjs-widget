<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\Card\View;
use DigitalCreative\NovaDashboard\Card\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class ChartJsWidget extends Widget
{
    public function title(string $title): self
    {
        return $this->withMeta([ 'title' => $title ]);
    }

    public function buttonTitle(string $title): self
    {
        return $this->withMeta([ 'buttonTitle' => $title ]);
    }

    public function icon(string $leadingIcon = null, string $trailingIcon = null): self
    {
        return $this->withMeta([ 'leadingIcon' => $leadingIcon, 'trailingIcon' => $trailingIcon ]);
    }

    public function addTab(string $widget): self
    {
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

        $title = $this->getMeta('title') ?? $this->getMeta('buttonTitle') ?? Str::title(__CLASS__);

        $tabs->prepend([
            'key' => $this->key(),
            'title' => $title,
            'leadingIcon' => $this->getMeta('leadingIcon'),
            'trailingIcon' => $this->getMeta('trailingIcon'),
            'buttonTitle' => $this->getMeta('buttonTitle', $title),
            'value' => $value,
        ]);

        foreach ($this->meta as $attribute => $_) {
            unset($this->meta[ $attribute ]);
        }

        return $tabs;
    }
}
