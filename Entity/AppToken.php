<?php

namespace Clarity\YandexOAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Clarity\YandexOAuthBundle\Model\Response\BaseResponse;

/**
 * Class AppToken
 *
 * @ORM\Table(name="clarity_yandex_oauth_app_token",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="idx_token_unique",
 *              columns={"app_name", "device_id"}
 *      )})
 * @ORM\Entity(repositoryClass="\Clarity\YandexOAuthBundle\Repository\AppTokenRepository")
 * @author Vladislav Shishko <13thMerlin@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class AppToken extends BaseResponse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="app_name", type="string")
     *
     * @var string
     */
    private $appName;

    /**
     * @ORM\Column(name="device_id", type="string", nullable=true)
     *
     * @var string
     */
    private $deviceId;

    /**
     * @ORM\Column(name="device_name", type="string", nullable=true)
     *
     * @var string
     */
    private $deviceName;

    /**
     * @ORM\Column(type="string", length=128)
     *
     * @Serializer\SerializedName("access_token")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $token;

    /**
     * @var string*
     *
     * @ORM\Column(type="string", length=128)
     *
     * @Serializer\SerializedName("token_type")
     * @Serializer\Type("string")
     *
     */
    protected $type;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Serializer\SerializedName("expires_in")
     * @Serializer\Type("integer")
     * @Serializer\Accessor(setter="deserializeExpiresSeconds")
     *
     * @var \DateTime
     */
    private $expired;

    /**
     * @param string $seconds
     */
    public function deserializeExpiresSeconds($seconds)
    {
        $now = new \DateTime();
        $now->add(new \DateInterval('PT' . $seconds . 'S'));
        $this->expired = $now;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * @param string $appName the app name
     *
     * @return self
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * @param string $deviceId
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @return string
     */
    public function getDeviceName()
    {
        return $this->deviceName;
    }

    /**
     * @param string $deviceName
     */
    public function setDeviceName($deviceName)
    {
        $this->deviceName = $deviceName;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token the token
     *
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param \DateTime $expired the expired
     *
     * @return self
     */
    public function setExpired(\DateTime $expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
