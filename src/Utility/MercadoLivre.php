<?php

namespace MercadoLivre\Utility;

use MercadoLivre\Utility\Resources\CategoryResource;
use MercadoLivre\Utility\Resources\ItemResource;
use MercadoLivre\Utility\Resources\UserResource;

/**
 * Class MercadoLivre
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class MercadoLivre
{
    public CategoryResource $categoryResource;

    public ItemResource $itemResource;

    public UserResource $userResource;

    protected int $attempts = 0;

    /**
     * @param  \MercadoLivre\Utility\MercadoLivreToken  $token
     */
    public function __construct(
        public MercadoLivreToken $token
    ) {
        $this->categoryResource = new CategoryResource($this);
        $this->itemResource = new ItemResource($this);
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
        $this->beforeResource();
        $response = \MercadoLivre\Facades\MercadoLivre::pendingRequest($this->token->mlToken())
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
        $this->attempts++;
        $this->beforeResource();
        $response = \MercadoLivre\Facades\MercadoLivre::pendingRequest($this->token->mlToken())
            ->get($resource, $query);

        if (mb_strtolower($response->json('message')) === mb_strtolower('Invalid scroll_id') && $this->attempts < 10) {
            sleep($this->attempts);

            return $this->resourceGet($resource, $query);
        } else {
            $this->attempts = 0;
        }

        return $response->json();
    }

    /**
     * @param  string  $resource
     * @param  array  $data
     * @return array
     *
     * @throws \Exception
     */
    public function resourceOption(string $resource, array $data = []): array
    {
        $this->beforeResource();
        $response = \MercadoLivre\Facades\MercadoLivre::pendingRequest($this->token->mlToken())
            ->send('OPTIONS', $resource);

        return $response->json();
    }

    /**
     * @param  string  $resource
     * @param  array  $data
     * @return array
     */
    public function resourcePost(string $resource, array $data = []): array
    {
        $this->beforeResource();
        $response = \MercadoLivre\Facades\MercadoLivre::pendingRequest($this->token->mlToken())
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
        $this->beforeResource();
        $response = \MercadoLivre\Facades\MercadoLivre::pendingRequest($this->token->mlToken())
            ->put($resource, $data);

        return $response->json();
    }
}
