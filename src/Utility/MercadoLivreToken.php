<?php

namespace MercadoLivre\Utility;

use Carbon\Carbon;

/**
 * Interface MercadoLivreToken
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
interface MercadoLivreToken
{
    /**
     * Return the refresh token.
     *
     * @return string
     */
    public function mlRefreshToken(): string;

    /**
     * Return the site.
     *
     * @return string
     */
    public function mlSite(): string;

    /**
     * Return the token
     *
     * @return string
     */
    public function mlToken(): string;

    /**
     * Return the seller id.
     *
     * @return int
     */
    public function mlUserId(): int;

    /**
     * Return the token expiration date.
     *
     * @return \Carbon\Carbon
     */
    public function mlExpiresOn(): Carbon;

    /**
     * @param  string  $token
     * @param  string  $refreshToken
     * @param  \Carbon\Carbon  $expiresIn
     * @return void
     */
    public function mlUpdateToken(string $token, string $refreshToken, Carbon $expiresIn): void;

    /**
     * @param  array  $user
     * @param  string  $token
     * @param  string  $refreshToken
     * @param  \Carbon\Carbon  $expiresIn
     * @return \MercadoLivre\Utility\MercadoLivreToken
     */
    public static function mlCreateToken(array $user, string $token, string $refreshToken, Carbon $expiresIn): MercadoLivreToken;
}
