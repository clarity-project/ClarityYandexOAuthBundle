<?php

namespace Clarity\YandexOAuthBundle\Manager;

use Guzzle\Service\ClientInterface;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class YandexOAuth extends AbstractManager
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $responseType;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var string
     */
    private $scope;

    /**
     * @var string
     */
    private $authorizationToken;

    /**
     * @param \Guzzle\Service\ClientInterface $client
     * @param array $apps
     * @param string $responseType
     * @param string $scope
     */
    public function __construct(
        ClientInterface $client,
        $apps,
        $responseType,
        $scope
    ) {
        parent::__construct($client);

        $this->apps = $apps;
        $this->responseType = $responseType;
        $this->scope = $scope;
    }

    /**
     * OAuth client 'getAuthorizationCode' method
     *
     * @param string $appName
     * @param string $state
     * @param string $deviceId
     * @param string $deviceName
     *
     * @return array
     */
    public function getAuthorizationCode(
        $appName,
        $state = null, 
        $deviceId = null, 
        $deviceName = null
    ) {
        return $this->call('getAuthorizationCode', array(
            'response_type' => $this->responseType,
            'client_id' => $this->apps[$appName]['client_id'],
            'state' => $state,
            'device_id' => $deviceId,
            'device_name' => $deviceName,
        ));
    }

    /**
     * OAuth client 'getToken' method
     *
     * @return array
     */
    public function getToken($appName, $code)
    {
        return $this->call('getToken', array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'client_id' => $this->apps[$appName]['client_id'],
            'client_secret' => $this->apps[$appName]['client_secret'],
            'device_id' => $this->apps[$appName]['client_id'],
            'device_name' => $this->apps[$appName]['client_id'],
        ));
    }
}
