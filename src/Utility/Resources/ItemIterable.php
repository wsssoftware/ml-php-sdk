<?php

namespace MercadoLivre\Utility\Resources;

use Illuminate\Support\Arr;
use MercadoLivre\Utility\MercadoLivre;

/**
 * Class ItemIterable
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class ItemIterable implements \Iterator
{
    protected string|false|null $scroll = null;

    protected array $current = [];

    public function __construct(
        protected MercadoLivre $mercadoLivre,
        protected array $query = [],
    ) {
    }

    public function current(): array
    {
        return $this->current;
    }

    public function next(): void
    {
        //
    }

    public function key(): string
    {
        return $this->scroll;
    }

    public function valid(): bool
    {
        $query = $this->query;
        $query += [
            'search_type' => 'scan',
        ];
        if (! empty($this->scroll)) {
            $query['scroll_id'] = $this->scroll;
        }
        $response = $this->mercadoLivre->itemResource->items($query);
        $results = Arr::get($response, 'results', []);
        $this->scroll = Arr::get($response, 'scroll_id');
        $this->current = $results;

        return count($results) > 0;
    }

    public function rewind(): void
    {
        $this->scroll = null;
    }
}
