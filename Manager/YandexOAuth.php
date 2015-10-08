<?php

namespace Clarity\YandexOAuthBundle\Manager;

use Clarity\YandexOAuthBundle\Entity\AppToken;
use Clarity\YandexOAuthBundle\Model\Response\CodeResponse;
use Guzzle\Service\ClientInterface;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class YandexOAuth extends AbstractManager
{
    /**
     * @var string
     */
    private $responseType;

    /**
     * @param \Guzzle\Service\ClientInterface $client
     * @param array $apps
     * @param string $responseType
     */
    public function __construct(ClientInterface $client, $apps, $responseType)
    {
        parent::__construct($client);

        $this->apps = $apps;
        $this->responseType = $responseType;
    }

    /**
     * @param string $appName
     * @param string $state
     * @param string $deviceId
     * @param string $deviceName
     *
     * @return CodeResponse
     */
    public function getAuthorizationCode(
        $appName,
        $state = null, 
        $deviceId = null, 
        $deviceName = null
    ) {
        return $this->call('getAuthorizationCode', array(
            'response_type' => $this->responseType,
            'client_id'     => $this->apps[$appName]['client_id'],
            'state'         => $state,
            'device_id'     => $deviceId,
            'device_name'   => $deviceName,
        ));
    }

    /**
     * @param $code
     * @param $appName
     * @return AppToken
     */
    public function getToken($code, $appName)
    {
        return $this->call('getToken', array(
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => $this->apps[$appName]['client_id'],
            'client_secret' => $this->apps[$appName]['client_secret'],
            'device_id'     => $this->apps[$appName]['client_id'],
            'device_name'   => $this->apps[$appName]['client_id'],
        ));
    }
}
