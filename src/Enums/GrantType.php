<?php

namespace MercadoLivre\Enums;

/**
 * Enum  GrantType
 *
 * Created by allancarvalho in janeiro 10, 2023
 */
enum GrantType: string
{
    case AUTHORIZATION_CODE = 'authorization_code';
    case REFRESH_TOKEN = 'refresh_token';
}
