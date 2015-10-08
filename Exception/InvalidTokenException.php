<?php

namespace Clarity\YandexOAuthBundle\Exception;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class InvalidTokenException extends \Exception
{
    protected $message = 'Token expired or does not exist. Try to generate new token with route "clarity_yandex_oauth_token_generage"';
}
