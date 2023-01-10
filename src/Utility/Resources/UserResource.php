<?php

namespace MercadoLivre\Utility\Resources;

/**
 * Class UserResource
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class UserResource extends Resource
{

    /**
     * @return array
     */
    public function me(): array
    {
        return $this->mercadoLivre->resourceGet('users/me');
    }

    /**
     * @param  string  $id
     * @return array
     */
    public function byId(string $id): array
    {
        return $this->mercadoLivre->resourceGet('users/'.$id);
    }

}
