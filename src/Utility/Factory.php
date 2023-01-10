<?php

namespace MercadoLivre\Utility;

/**
 * Class Factory
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
class Factory
{
    /**
     * @param  \MercadoLivre\Utility\MercadoLivreToken  $token
     * @return \MercadoLivre\Utility\MercadoLivre
     */
    public function from(MercadoLivreToken $token): MercadoLivre
    {
        return new MercadoLivre($token);
    }
}
