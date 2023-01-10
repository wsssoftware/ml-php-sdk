<?php

namespace MercadoLivre\Utility;

use Illuminate\Support\Facades\Route;
use InvalidArgumentException;

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
        $redirect = config('mercadolivre.redirect_uri');
        if (empty($id)) {
            throw new InvalidArgumentException('MercadoLivre client_id is not defined on config/mercadolivre.php');
        }
        $payload = [
            'response_type' => 'code',
            'client_id' => $id,
        ];
        if (! empty($state)) {
            $payload['state'] = $state;
        }
        if (! empty($redirect)) {
            if (str_starts_with($redirect, 'https://')) {
                $payload['redirect_uri'] = $redirect;
            } elseif (str_starts_with($redirect, 'http://')) {
                throw new InvalidArgumentException('MercadoLivre redirect_uri must be https');
            } elseif (Route::has($redirect)) {
                $payload['redirect_uri'] = route($redirect);
            }
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
     * @param  string  $model
     * @param  string  $code
     * @return \MercadoLivre\Utility\MercadoLivreToken|null
     */
    public function oauth(string $model, string $code): MercadoLivreToken|null
    {
        if (! class_exists($model)) {
            throw new InvalidArgumentException("Model $model does not exists");
        }
        if (! is_subclass_of($model, MercadoLivreToken::class)) {
            throw new InvalidArgumentException("Model $model must be a subclass of ".MercadoLivreToken::class);
        }

        return null;
    }
}
