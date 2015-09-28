<?php

namespace Clarity\YandexOAuthBundle\Service;

use Doctrine\ORM\EntityManager;
use Clarity\YandexOAuthBundle\Exception\GetAuthorizationCodeException;
use Clarity\YandexOAuthBundle\Exception\GetAuthorizationTokenException;
use Clarity\YandexOAuthBundle\Exception\InvalidTokenException;
use Clarity\YandexOAuthBundle\Repository\AppTokenRepository;
use Clarity\YandexOAuthBundle\Manager\YandexOAuth;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 * Service registered clarity_yandex.oauth.service
 */
class YandexOAuthService
{
    /**
     * @var YandexOAuth
     */
    private $guzzleManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param YandexOAuth $guzzleManager
     * @param EntityManager $entityManager
     */
    public function __construct(YandexOAuth $guzzleManager, EntityManager $entityManager)
    {
        $this->guzzleManager = $guzzleManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $appName
     * @param string $scope
     * @param string|null $deviceId
     *
     * @return \Clarity\YandexOAuthBundle\Entity\AppToken
     * @throws InvalidTokenException
     */
    public function getCachedToken($appName, $scope, $deviceId = null)
    {
        $appToken = $this
            ->getAppTokenRepository()
            ->getAppTokenByAppNameAndScopeAndDeviceId($appName, $scope, $deviceId);

        if (null === $appToken) {
            throw new InvalidTokenException();
        }

        return $appToken;
    }

    /**
     * Exchange received authorization code on token and save token
     *
     * @param string $code - authorization code
     * @param string $appName
     * @param string $scope
     * @param string|null $deviceId
     * @param string|null $deviceName
     *
     * @return \Clarity\YandexOAuthBundle\Entity\AppToken
     *
     * @throws GetAuthorizationTokenException
     */
    public function exchangeCodeToToken($code, $appName, $scope, $deviceId = null, $deviceName = null)
    {
        $appToken = $this
            ->guzzleManager
            ->getToken($code, $appName);

        if ($appToken->hasError()) {
            throw new GetAuthorizationTokenException($appToken->getError());
        }

        $appToken->setAppName($appName);
        $appToken->setScope($scope);
        $appToken->setDeviceId($deviceId);
        $appToken->setDeviceName($deviceName);

        $existedAppToken = $this
            ->getAppTokenRepository()
            ->getAppTokenByAppNameAndScopeAndDeviceId($appName, $scope, $deviceId);

        if ($existedAppToken) {
            $appToken->setId($existedAppToken->getId());

            $this->entityManager->merge($appToken);
        } else {
            $this->entityManager->persist($appToken);
        }

        $this->entityManager->flush();

        return $appToken;
    }

    /**
     * @param string $appName
     * @param string $state
     * @param null $deviceId
     * @param null $deviceName
     *
     * @return \Clarity\YandexOAuthBundle\Model\Response\CodeResponse
     * @throws GetAuthorizationCodeException
     */
    public function getAuthorizationCode($appName, $state, $deviceId = null, $deviceName = null)
    {
        $codeResponse = $this
            ->guzzleManager
            ->getAuthorizationCode($appName, $state, $deviceId, $deviceName);

        if ($codeResponse->hasError()) {
            throw new GetAuthorizationCodeException($codeResponse->getError());
        }

        return $codeResponse;
    }

    /**
     * @return AppTokenRepository
     */
    protected function getAppTokenRepository()
    {
        return $this->entityManager->getRepository('ClarityYandexOAuthBundle:AppToken');
    }
}
