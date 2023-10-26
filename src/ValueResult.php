<?php

declare(strict_types = 1);

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\ValueResult as BaseValueResult;
use Illuminate\Support\Collection;

/**
 * Class Value
 * @method self labels(array $labels)
 */
class ValueResult extends BaseValueResult
{
    private Collection $collection;

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->collection = collect();
    }

    public function addDataset(DataSet ...$data): self
    {
        $this->collection->push(...$data);

        return $this;
    }

    public function jsonSerialize(): array
    {
        return array_merge([
            'dataset' => $this->collection,
        ], parent::jsonSerialize());
    }
}
