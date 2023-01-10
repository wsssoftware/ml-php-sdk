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
        $userId = $this->mercadoLivre->token->mlUserId();
        $this->query += [
            'search_type' => 'scan',
            'limit' => 100,
            'status' => 'active',
        ];
        if (! empty($this->scroll)) {
            $this->query['scroll_id'] = $this->scroll;
        }
        $response = $this->mercadoLivre->resourceGet("users/$userId/items/search", $this->query);
        $results = Arr::get($response, 'results', []);
        $this->scroll = Arr::get($response, 'scroll_id');
        $this->current = $results;
        usleep(500000);

        return count($results) > 0;
    }

    public function rewind(): void
    {
        $this->scroll = null;
    }
}
