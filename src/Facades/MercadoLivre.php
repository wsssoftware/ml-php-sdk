<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace MercadoLivre\Facades;

use Illuminate\Support\Facades\Facade;
use MercadoLivre\Utility\MercadoLivreToken;

/**
 * @method static string authUrl()
 * @method static \MercadoLivre\Utility\MercadoLivre from(MercadoLivreToken $token)
 * @method static \MercadoLivre\Utility\MercadoLivreToken oauth(string $model, string $code)
 * @method static \Illuminate\Http\Client\PendingRequest pendingRequest(string $token)
 * @method static \MercadoLivre\Utility\MercadoLivreToken refresh(MercadoLivreToken $token)
 *
 * @see \MercadoLivre\Utility\Factory
 */
class MercadoLivre extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \MercadoLivre\Utility\Factory::class;
    }
}
