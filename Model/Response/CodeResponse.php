<?php


namespace Clarity\YandexOAuthBundle\Model\Response;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CodeResponse
 *
 * @author Vladislav Shishko <13thMerlin@gmail.com>
 */
class CodeResponse extends BaseResponse
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("Location")
     * @Serializer\Type("string")
     */
    protected $location;

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

}