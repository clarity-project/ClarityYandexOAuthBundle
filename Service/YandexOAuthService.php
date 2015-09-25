<?php

namespace Clarity\YandexOAuthBundle\Service;

use Guzzle\Service\ClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Clarity\YandexOAuthBundle\Manager\YandexOAuth;
use Clarity\YandexOAuthBundle\Repository\AppTokenRepository;
use Clarity\YandexOAuthBundle\Exception\InvalidTokenException;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 * Service registered clarity_yandex.oauth.service
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

    /**
     * @param string $appName
     * @param string $scope
     *
     * @return \Clarity\YandexOAuthBundle\Model\AppToken
     * @throws InvalidTokenException
     */
    public function getCachedToken($appName, $scope)
    {
        $appToken = $this
            ->appTokenRepository
            ->getAppTokenByAppNameAndScope($appName, $scope);

        if (null === $appToken) {
            throw new InvalidTokenException();
        }

        return $appToken;
    }

    /**
     * @param string $code
     * @param string $appName
     *
     * @return \Clarity\YandexOAuthBundle\Model\AppToken
     * @throws InvalidTokenException
     */
    public function exchangeCodeToToken($code, $appName)
    {
        $response = $this->guzzleManager->getToken($code, $appName);

        die(var_dump($response));

        if ($response->hasError()) {
            throw \Exception($response->getError()->getMessage());
        }

        return $response;
    }

    /**
     * @param string $appName
     * @param string $scope
     *
     * @return \Clarity\YandexOAuthBundle\Model\CodeResponse
     * @throws \Exception
     */
    public function getAuthorizationCode($appName, $scope)
    {
        $response = $this->guzzleManager->getAuthorizationCode($appName, $scope);

        if ($response->hasError()) {
            throw \Exception($response->getError()->getMessage());
        }

        return $response;
    }
}
