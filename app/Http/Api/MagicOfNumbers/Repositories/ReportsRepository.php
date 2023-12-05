<?php

namespace App\Http\Api\MagicOfNumbers\Repositories;

use App\Http\Api\MagicOfNumbers\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Exception;

class ReportsRepository
{
    protected Collection $items;

    /**
     * @throws Exception
     */
    public function __construct(array $items = null)
    {
        if ($items === null)
            $this->items = collect();
        if (is_array($items)) {
            $this->items = $this->createReportsFromArray($items);
        }
    }

    /**
     * @throws Exception
     */
    private function createReportsFromArray(array $items): Collection
    {
        $collection = collect();
        foreach ($items as $item) {
            $report = new Report($item);
            $collection->add($report);
        }
        return $collection;
    }

    /**
     * @throws Exception
     */
    public function addReport(array|Report $item): static
    {
        if ($item instanceof Report) {
            $this->items->add($item);
        } else {
            $this->items->add(
                new Report($item)
            );
        }
        return $this;
    }

    public function getReports(): Collection
    {
        return $this->items;
    }
}

