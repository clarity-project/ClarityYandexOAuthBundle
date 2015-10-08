<?php

namespace Clarity\YandexOAuthBundle\Client\Command;

use Guzzle\Http\Message\RequestInterface;

/**
 * Class YandexOAuthGetCodeCommand
 *
 * @author Vladislav Shishko <13thMerlin@gmail.com>
 */
class YandexOAuthGetCodeCommand extends AbstractDeserializeCommand
{
    /**
     * @var \JMS\Serializer\SerializerInterface
     */
    public $serializer;

    /** @var RequestInterface The request object associated with the command */
    protected $request;

    /**
     * {@inheritDoc}
     */
    public function process()
    {
        /**  @var $headers array */
        $headers = $this->request->getResponse()->getHeaders()->toArray();

        $arrayHeaders = array_combine(array_keys($headers), array_column($headers, 0));

        $this->result = $this->serializer->deserialize(
            json_encode($arrayHeaders),
            $this->getOperation()->getResponseClass(),
            'json'
        );
    }
}
