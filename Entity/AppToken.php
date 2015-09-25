<?php

namespace Clarity\YandexOAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Device
 *
 * @ORM\Table(name="clarity_yandex_oauth_app_token",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="idx_client_id_scope_unique",
 *              columns={"client_id", "scope"}
 *      )})
 * @ORM\Entity(repositoryClass="\Clarity\YandexOAuthBundle\Repository\AppTokenRepository")
 * @author Vladislav Shishko <13thMerlin@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class AppToken
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
     * @ORM\Column(name="client_id", type="string")
     *
     * @var string
     */
    private $appName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $scope;

    /**
     * @ORM\Column(type="string", length=32)
     *
     * @var string
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $expired;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param mixed $scopes the scope
     *
     * @return self
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
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
}