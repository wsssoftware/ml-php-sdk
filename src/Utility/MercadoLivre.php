<?php

namespace MercadoLivre\Utility;

use MercadoLivre\Utility\Resources\UserResource;

/**
 * Class MercadoLivre
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class MercadoLivre
{
    public UserResource $userResource;

    /**
     * @param  \MercadoLivre\Utility\MercadoLivreToken  $token
     */
    public function __construct(
        protected MercadoLivreToken $token
    ) {
        $this->userResource = new UserResource($this);
    }

    /**
     * @return void
     */
    protected function beforeResource(): void
    {
        if ($this->token->mlExpiresOn()->isPast()) {
            $this->refreshToken();
        }
    }

    /**
     * @return void
     */
    public function refreshToken(): void
    {
        $this->token = \MercadoLivre\Facades\MercadoLivre::refresh($this->token);
    }

    /**
     * @param  string  $resource
     * @param  array  $data
     * @return array
     */
    public function resourceDelete(string $resource, array $data = []): array
    {
        $response = \MercadoLivre\Facades\MercadoLivre::peddingRequest($this->token->mlToken())
            ->delete($resource, $data);

        return $response->json();
    }

    /**
     * @param  string  $resource
     * @param  array  $query
     * @return array
     */
    public function resourceGet(string $resource, array $query = []): array
    {
        $response = \MercadoLivre\Facades\MercadoLivre::peddingRequest($this->token->mlToken())
            ->get($resource, $query);

        return $response->json();
    }

    /**
     * @param  string  $resource
     * @param  array  $data
     * @return array
     */
    public function resourcePost(string $resource, array $data = []): array
    {
        $response = \MercadoLivre\Facades\MercadoLivre::peddingRequest($this->token->mlToken())
            ->post($resource, $data);

        return $response->json();
    }

    /**
     * @param  string  $resource
     * @param  array  $data
     * @return array
     */
    public function resourcePut(string $resource, array $data = []): array
    {
        $response = \MercadoLivre\Facades\MercadoLivre::peddingRequest($this->token->mlToken())
            ->put($resource, $data);

        return $response->json();
    }
}
