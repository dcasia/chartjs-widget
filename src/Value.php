<?php

namespace DigitalCreative\ChartJsWidget;

use DigitalCreative\NovaDashboard\ValueResult;
use Illuminate\Support\Collection;

class Value extends ValueResult
{

    private Collection $collection;

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->collection = collect();

    }

    public function add(DataSet ...$data): self
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
