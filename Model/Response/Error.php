<?php

namespace Clarity\YandexOAuthBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class Error
{
    /**
     * @Serializer\SerializedName("error")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $code;

    /**
     * @Serializer\SerializedName("error_description")
     * @Serializer\Type("string")
     *
     * @var string
     */
    private $description;

    /**
     * @param string $code
     * @param string $description
     */
    public function __construct($code, $description)
    {
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code the code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code . ':' . $this->description;
    }
}
