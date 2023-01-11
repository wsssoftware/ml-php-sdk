<?php

namespace MercadoLivre\Utility\Resources;

/**
 * Class ItemResource
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class ItemResource extends Resource
{
    /**
     * @param  string  $id
     * @return array
     */
    public function byId(string $id): array
    {
        return $this->mercadoLivre->resourceGet('items/'.$id);
    }

    /**
     * @param  array  $ids
     * @return array
     */
    public function byIds(array $ids): array
    {
        return $this->mercadoLivre->resourceGet('/items', ['ids' => implode(',', $ids)]);
    }

    /**
     * @param  array  $query
     * @return array
     */
    public function items(array $query = []): array
    {
        $userId = $this->mercadoLivre->token->mlUserId();

        return $this->mercadoLivre->resourceGet("users/$userId/items/search", $query);
    }

    /**
     * @param  array  $query
     * @return \MercadoLivre\Utility\Resources\ItemIterable
     */
    public function itemIterable(array $query = []): ItemIterable
    {
        return new ItemIterable($this->mercadoLivre, $query);
    }
}
