<?php

namespace MercadoLivre\Utility;

use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;
use MercadoLivre\Enums\GrantType;

/**
 * Class Factory
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class Factory
{

    /**
     * @param  string|null  $state
     * @return string
     */
    public function authUrl(string $state = null): string
    {
        $id = config('mercadolivre.client_id');

        if (empty($id)) {
            throw new InvalidArgumentException('MercadoLivre client_id is not defined on config/mercadolivre.php');
        }
        $payload = [
            'response_type' => 'code',
            'client_id' => $id,
        ];
        $redirect = $this->getRedirect();
        if (!empty($redirect)) {
            $payload['redirect_uri'] = $redirect;
        }
        if (!empty($state)) {
            $payload['state'] = $state;
        }

        $query = http_build_query($payload);

        return "https://auth.mercadolivre.com.br/authorization?$query";
    }

    /**
     * @param  \MercadoLivre\Utility\MercadoLivreToken  $token
     * @return \MercadoLivre\Utility\MercadoLivre
     */
    public function from(MercadoLivreToken $token): MercadoLivre
    {
        return new MercadoLivre($token);
    }

    /**
     * @return string|null
     */
    protected function getRedirect(): ?string
    {
        $redirect = config('mercadolivre.redirect_uri');
        if (empty($redirect)) {
           return null;
        }
        if (str_starts_with($redirect, 'https://')) {
            return $redirect;
        } elseif (str_starts_with($redirect, 'http://')) {
            throw new InvalidArgumentException('MercadoLivre redirect_uri must be https');
        } elseif (Route::has($redirect)) {
            return route($redirect);
        }
        return null;
    }

    /**
     * @param  \MercadoLivre\Enums\GrantType  $type
     * @param  string  $value
     * @return array
     */
    protected function getToken(GrantType $type, string $value): array
    {
        $valueKey = $type === GrantType::AUTHORIZATION_CODE ? 'code' : 'refresh_token';
        $payload = [
            'grant_type' => $type->value,
            'client_id' => config('mercadolivre.client_id'),
            'client_secret' => config('mercadolivre.client_secret'),
            $valueKey => $value,
        ];
        if ($type === GrantType::AUTHORIZATION_CODE) {
            $redirect = $this->getRedirect();
            if (!empty($redirect)) {
                $payload['redirect_uri'] = $redirect;
            }
        }

        $response = $this->peddingRequest(null)
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ])
            ->post('/oauth/token', $payload);

        $token = $response->json();
        if (isset($token['error'])) {
            throw new InvalidArgumentException(sprintf(
                'MercadoLivre error: %s "%s" with message "%s"',
                Arr::get($token, 'status'),
                Arr::get($token, 'error'),
                Arr::get($token, 'message', 'no message')
            ));
        }
        if (
            !isset($token['access_token']) || !isset($token['refresh_token']) || !isset($token['expires_in'])
            || !isset($token['user_id']) || !isset($token['scope'])
        ) {
            throw new InvalidArgumentException('MercadoLivre error: invalid response');
        }
        $token['expires_in'] = Carbon::now()->addSeconds($token['expires_in'])->subSeconds(120);
        return $token;
    }

    /**
     * @param  string  $model
     * @param  string  $code
     * @return \MercadoLivre\Utility\MercadoLivreToken|null
     */
    public function oauth(string $model, string $code): MercadoLivreToken|null
    {
        if (!class_exists($model)) {
            throw new InvalidArgumentException("Model $model does not exists");
        }
        if (!is_subclass_of($model, MercadoLivreToken::class)) {
            throw new InvalidArgumentException("Model $model must be a subclass of ".MercadoLivreToken::class);
        }

        $token = $this->getToken(GrantType::AUTHORIZATION_CODE, $code);
        $user = $this->peddingRequest($token['access_token'])->get('/users/me')->json();

        return $model::mlCreateToken(
            $user,
            $token['access_token'],
            $token['refresh_token'],
            $token['expires_in'],
        );
    }

    /**
     * @param  string|null  $token
     * @return \Illuminate\Http\Client\PendingRequest
     */
    public function peddingRequest(?string $token): PendingRequest
    {
        $pendingRequest = Http::baseUrl('https://api.mercadolibre.com');
        if (!empty($token)) {
            $pendingRequest = $pendingRequest->withToken($token);
        }
        return $pendingRequest;
    }

    /**
     * @param  \MercadoLivre\Utility\MercadoLivreToken  $mercadoLivreToken
     * @return \MercadoLivre\Utility\MercadoLivreToken
     */
    public function refresh(MercadoLivreToken $mercadoLivreToken): MercadoLivreToken
    {
        $token = $this->getToken(GrantType::REFRESH_TOKEN, $mercadoLivreToken->mlRefreshToken());
        $mercadoLivreToken->mlUpdateToken(
            $token['access_token'],
            $token['refresh_token'],
            $token['expires_in'],
        );
        return $mercadoLivreToken;
    }
}
