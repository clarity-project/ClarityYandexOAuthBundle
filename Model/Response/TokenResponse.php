<?php

namespace Clarity\YandexOAuthBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TokenResponse
 *
 * @author Vladislav Shishko <13thMerlin@gmail.com>
 * @author varloc2000 <varloc2000@gmail.com>
 */
class TokenResponse extends BaseResponse
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("access_token")
     * @Serializer\Type("string")
     */
    protected $token;

    /**
     * @var string*
     *
     * @Serializer\SerializedName("token_type")
     * @Serializer\Type("string")
     *
     */
    protected $type;

    /**
     * @var integer
     *
     * @Serializer\SerializedName("expires_in")
     * @Serializer\Type("integer")
     */
    protected $expiresIn;

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
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

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }
}
