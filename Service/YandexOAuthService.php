<?php

namespace Clarity\YandexOAuthBundle\Service;

use Guzzle\Service\ClientInterface;
use Clarity\YandexOAuthBundle\Manager\YandexOAuth;
use Clarity\YandexOAuthBundle\Repository\AppTokenRepository;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class YandexOAuthService
{
    /**
     * @var \Clarity\YandexOAuthBundle\Manager\YandexOAuth
     */
    private $guzzleManager;

    /**
     * @var \Clarity\YandexOAuthBundle\Repository\AppTokenRepository
     */
    private $appTokenRepository;

    public function __construct(YandexOAuth $guzzleManager, AppTokenRepository $appTokenRepository)
    {
        $this->guzzleManager = $guzzleManager;
        $this->appTokenRepository = $appTokenRepository;
    }

    public function getTokenByAppAndScope($appName, $scope)
    {
        $appToken = $this->appTokenRepository->getAppTokenByAppNameAndScope($appName, $scope);
        var_dump($appToken);

        if (null === $appToken) {
            $this->getToken();
        }
    }

    private function getToken()
    {
        die(var_dump('get new'));
    }
}
