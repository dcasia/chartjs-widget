<?php

namespace DigitalCreative\ChartWidget;

use DigitalCreative\NovaDashboard\ValueResult;
use Illuminate\Support\Collection;
use RuntimeException;

class Value extends ValueResult
{

    private Collection $collection;
    private array $labels;

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->collection = collect();

    }

    public function add(Datasets $data): self
    {
        $this->collection->push($data);

        return $this;
    }

    public function labels(array $labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    public function jsonSerialize(): array
    {


        $result = $this->collection->every(function (Datasets $items) {
            return count($items->data) === count($this->labels);
        });

        if (!$result) {

            throw new RuntimeException('Labels and data must to have the same length!');

        }

        return array_merge([
            'dataset' => $this->collection,
            'labels' => $this->labels,
        ], parent::jsonSerialize());
    }

}
