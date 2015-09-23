<?php

namespace Clarity\YandexOAuthBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class BaseResponse
{
    /**
     * @Serializer\Type("Clarity\YandexOAuthBundle\Model\Response\Error")
     *
     * @var \Clarity\YandexOAuthBundle\Model\Response\Error
     */
    private $error;

    /**
     * @return bool
     */
    public function hasError()
    {
        return ($this->error instanceof Error) ? true : false;
    }

    /**
     * @return \Clarity\YandexOAuthBundle\Model\Response\Error|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param array $error the error
     *
     * @return self
     */
    public function setError(Error $error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getErrorCode()
    {
        return ($this->error instanceof Error)
            ? $this->error->getCode()
            : null;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage()
    {
        return ($this->error instanceof Error)
            ? $this->error->getMessage()
            : null;
    }
}
