<?php

namespace MercadoLivre\Utility;

/**
 * Interface MercadoLivreToken
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
interface MercadoLivreToken
{
    /**
     * Return the token
     *
     * @return string
     */
    public function MLToken(): string;

    /**
     * Return the refresh token.
     *
     * @return string
     */
    public function MLRefreshToken(): string;

    /**
     * Return the token expiration date.
     *
     * @return \DateTime
     */
    public function MLExpiresOn(): \DateTime;

    /**
     * @param  string  $token
     * @param  string  $refreshToken
     * @param  \DateTime  $expiresOn
     * @return void
     */
    public function saveNewToken(string $token, string $refreshToken, \DateTime $expiresOn): void;
}
