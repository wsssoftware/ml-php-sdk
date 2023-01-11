<?php

namespace MercadoLivre\Utility\Resources;

/**
 * Class CategoryResource
 *
 * Created by allancarvalho in janeiro 11, 2023
 */
class CategoryResource extends Resource
{
    /**
     * @return array
     */
    public function categories(): array
    {
        $site = $this->mercadoLivre->token->mlSite();
        return $this->mercadoLivre->resourceOption("sites/$site/categories");
    }

    /**
     * @param  string  $id
     * @return array
     */
    public function byId(string $id): array
    {
        return $this->mercadoLivre->resourceGet("/categories/$id");
    }
}
