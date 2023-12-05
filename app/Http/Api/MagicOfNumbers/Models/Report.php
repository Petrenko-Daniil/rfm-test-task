<?php

namespace App\Http\Api\MagicOfNumbers\Models;

use Exception;

class Report
{
    public string|int $id;
    public string $name;
    public string|null $description;
    public string|null $index;
    public array|null $query;
    public array|null $tags;
    public int|null $total;
    public array|null $result;
    public array|null $aggregations;

    /**
     * @throws Exception
     */
    public function __construct(array $args)
    {
        $this->id = $args['id'] ?? (throw new Exception('No id provided for Report'));
        $this->name = $args['name'] ?? (throw new Exception('No name provided for Report'));
        $this->description = $args['description'] ?? null;
        $this->index = $args['index'] ?? null;
        $this->query = $args['query'] ?? null;
        $this->tags = $args['tags'] ?? null;
        $this->setExpandedResults($args);
    }

    public function setExpandedResults(array $args): static
    {
        $this->total = $args['total'] ?? null;
        $this->result = $args['result'] ?? null;
        $this->aggregations = $args['aggregations'] ?? null;
        return $this;
    }

    public function prepareForView(): static
    {
        if (!$this->aggregations)
            return $this;
        foreach ($this->aggregations['segments']['buckets'] as &$bucket) {
            $bucket['average_bill'] = round($bucket['total']['value'] / $bucket['orders']['value'], 0);
            $bucket['description'] = $bucket['description'] ?? 'Description for group is not provided';
            $bucket['total_percent'] = round($bucket['doc_count'] / ($this->total ?? 1) * 100, 1);
            $bucket['doc_count'] = number_format($bucket['doc_count'], 0, '', ' ');
            $bucket['total']['value'] = number_format($bucket['total']['value'], 0, '', ' ');
            $bucket['orders']['value'] = number_format($bucket['orders']['value'], 0, '', ' ');
        }
        return $this;
    }

}
