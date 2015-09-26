<?php

namespace Clarity\YandexOAuthBundle\Service;

use Guzzle\Service\ClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManager;
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
     * @var YandexOAuth
     */
    private $guzzleManager;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(YandexOAuth $guzzleManager, EntityManager $entityManager)
    {
        $this->guzzleManager = $guzzleManager;
        $this->em = $entityManager;
    }

    /**
     * @param string $appName
     * @param string $scope
     *
     * @return \Clarity\YandexOAuthBundle\Entity\AppToken
     * @throws InvalidTokenException
     */
    public function getCachedToken($appName, $scope)
    {
        $appToken = $this
            ->em->getRepository('ClarityYandexOAuthBundle:AppToken')
            ->getAppTokenByAppNameAndScope($appName, $scope);

        if (null === $appToken) {
            throw new InvalidTokenException();
        }

        return $appToken;
    }

    /**
     * Exchange received authorization code on token and save token
     *
     * @param string $code
     * @param string $appName
     *
     * @return \Clarity\YandexOAuthBundle\Entity\AppToken
     * @throws InvalidTokenException
     */
    public function exchangeCodeToToken($code, $appName)
    {
        $appToken = $this->guzzleManager->getToken($code, $appName);

        if ($appToken->hasError()) {
            throw \Exception($appToken->getError()->getMessage());
        }

        $this->em->persist($appToken);
        $this->em->flush();

        return $appToken;
    }

    /**
     * @param string $appName
     * @param string $state
     *
     * @return \Clarity\YandexOAuthBundle\Model\Response\CodeResponse
     * @throws \Exception
     */
    public function getAuthorizationCode($appName, $state, $deviceId = null, $deviceName = null)
    {
        $codeResponse = $this
            ->guzzleManager
            ->getAuthorizationCode($appName, $state, $deviceId, $deviceName);

        if ($codeResponse->hasError()) {
            throw new \Exception($codeResponse->getError()->getDescription());
        }

        return $codeResponse;
    }
}
