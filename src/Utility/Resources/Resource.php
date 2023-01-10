<?php

namespace MercadoLivre\Utility\Resources;

use MercadoLivre\Utility\MercadoLivre;

/**
 * Class Resource
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
abstract class Resource
{
    /**
     * @param  \MercadoLivre\Utility\MercadoLivre  $mercadoLivre
     */
    public function __construct(
        protected MercadoLivre $mercadoLivre
    ) {
        //
    }
}
