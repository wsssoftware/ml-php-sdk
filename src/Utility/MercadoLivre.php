<?php

namespace MercadoLivre\Utility;

/**
 * Class MercadoLivre
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class MercadoLivre
{
    /**
     * @param  \MercadoLivre\Utility\MercadoLivreToken  $token
     */
    public function __construct(
        protected MercadoLivreToken $token
    ) {
        //
    }
}
