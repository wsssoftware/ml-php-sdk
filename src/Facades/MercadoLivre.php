<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace MercadoLivre\Facades;

use Illuminate\Support\Facades\Facade;
use MercadoLivre\Utility\MercadoLivreToken;

/**
 * @method static \MercadoLivre\Utility\MercadoLivreToken from(MercadoLivreToken $token)
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
