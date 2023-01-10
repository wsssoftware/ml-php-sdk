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
    public function mlToken(): string;

    /**
     * Return the refresh token.
     *
     * @return string
     */
    public function mlRefreshToken(): string;

    /**
     * Return the token expiration date.
     *
     * @return \DateTime
     */
    public function mlExpiresOn(): \DateTime;

    /**
     * @param  string  $token
     * @param  string  $refreshToken
     * @param  \DateTime  $expiresOn
     * @return void
     */
    public function mlUpdateToken(string $token, string $refreshToken, \DateTime $expiresOn): void;

    /**
     * @param  array  $mlUser
     * @param  string  $token
     * @param  string  $refreshToken
     * @param  \DateTime  $expiresOn
     * @return \MercadoLivre\Utility\MercadoLivreToken
     */
    public static function mlCreateToken(array $mlUser, string $token, string $refreshToken, \DateTime $expiresOn): MercadoLivreToken;


}
