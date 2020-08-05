<?php

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\WidgetOptionTab;
use DigitalCreative\NovaDashboard\Filters;
use DigitalCreative\NovaDashboard\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

abstract class LineChartWidget extends Widget
{

    public function resolveWidgetOptions()
    {
        return new WidgetOptionTab('Options', [
            'legend' => [
                'display' => false
            ]
        ]);
    }

    public function component(): string
    {
        return 'line-chart-widget';
    }

    public function settings(): array
    {
        return [

            Text::make(__('Title'), static::TITLE)->default(static function () {
                return Str::title(Str::snake(class_basename(static::class), ' '));
            }),

            Text::make(__('Color Scheme'), static::COLOR_SCHEME)
                ->default('tableau.Classic10')
                ->rules([ 'startsWith:brewer.,office.,tableau.', 'nullable' ])
                ->help(__('See: :link for available options.', [ 'link' => '<a target="_blank" href="https://nagix.github.io/chartjs-plugin-colorschemes/colorchart.html">#color-schema</a>' ])),

            KeyValue::make(__('Padding'), static::PADDING)
                    ->disableEditingKeys()
                    ->disableDeletingRows()
                    ->disableAddingRows()
                    ->default([
                        static::PADDING_TOP => 40,
                        static::PADDING_LEFT => 0,
                        static::PADDING_RIGHT => 0,
                        static::PADDING_BOTTOM => 0,
                    ]),

            Heading::make(__('Tooltip')),

            BooleanGroup::make(__('Settings'), static::TOOLTIP_SETTINGS)
                        ->options([
                            static::TOOLTIP_SHOW => __('Show'),
                            static::TOOLTIP_INTERSECT => __('Intersect'),
                            static::TOOLTIP_SHOW_COLORS => __('Show Colors'),
                        ])
                        ->default([
                            static::TOOLTIP_SHOW => true,
                            static::TOOLTIP_INTERSECT => true,
                            static::TOOLTIP_SHOW_COLORS => false,
                        ]),

            KeyValue::make(__('Settings'), static::TOOLTIPS)
                    ->default([
                        'intersect' => true,
                    ])
                    ->help(__('See: :link for available options.', [ 'link' => '<a target="_blank" href="https://www.chartjs.org/docs/latest/configuration/tooltip.html#tooltip-configuration">#tooltip-configuration</a>' ])),

            Heading::make(__('Legend')),

            Boolean::make(__('Show'), static::SHOW_LEGEND)->default(true),

            Select::make(__('Positioning'), static::LEGEND_POSITIONING)
                  ->default(static::LEGEND_POSITIONING_BOTTOM)
                  ->options([
                      static::LEGEND_POSITIONING_TOP => __('Top'),
                      static::LEGEND_POSITIONING_LEFT => __('Left'),
                      static::LEGEND_POSITIONING_BOTTOM => __('Bottom'),
                      static::LEGEND_POSITIONING_RIGHT => __('Right'),
                  ]),

            Select::make(__('Alignment'), static::LEGEND_ALIGNMENT)
                  ->default(static::LEGEND_ALIGNMENT_START)
                  ->options([
                      static::LEGEND_ALIGNMENT_START => __('Start'),
                      static::LEGEND_ALIGNMENT_CENTER => __('Center'),
                      static::LEGEND_ALIGNMENT_END => __('End'),
                  ]),

            Heading::make(__('Horizontal Axis (xAxes)')),

            BooleanGroup::make(__('Settings'), static::HORIZONTAL_AXIS)
                        ->options([
                            static::AXIS_DISPLAY => __('Display Axis'),
                            static::AXIS_SHOW_GRID_LINES => __('Display Grid Lines'),
                            static::AXIS_SHOW_GRID_LINES_BORDER => __('Display Grid Lines Border'),
                        ]),

            Number::make(__('Tick Padding'), static::HORIZONTAL_AXIS_TICK_PADDING)->default(0),
            Number::make(__('Tick Line Height'), static::HORIZONTAL_AXIS_TICK_LINE_HEIGHT)->default(1),

            Heading::make(__('Vertical Axis (yAxes)')),

            BooleanGroup::make(__('Settings'), static::VERTICAL_AXIS)
                        ->options([
                            static::AXIS_DISPLAY => __('Display Axis'),
                            static::AXIS_SHOW_GRID_LINES => __('Display Grid Lines'),
                            static::AXIS_SHOW_GRID_LINES_BORDER => __('Display Grid Lines Border'),
                        ]),

            Number::make(__('Tick Padding'), static::VERTICAL_AXIS_TICK_PADDING)->default(0),
            Number::make(__('Tick Line Height'), static::VERTICAL_AXIS_TICK_LINE_HEIGHT)->default(1),

        ];
    }

    /**
     * See link bellow for all possible values that can be given to this function
     *
     * @link https://nagix.github.io/chartjs-plugin-colorschemes/colorchart.html
     *
     * @param string $colorScheme
     *
     * @return $this
     */
    public function colorScheme(string $colorScheme): self
    {
        return $this->withMeta([ 'colorScheme' => $colorScheme ]);
    }

    public function value(): ValueResult
    {
        return new ValueResult();
    }

}
