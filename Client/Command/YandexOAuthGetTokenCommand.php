<?php

namespace Clarity\YandexOAuthBundle\Client\Command;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class YandexOAuthGetTokenCommand extends AbstractDeserializeCommand
{
    public function process()
    {
        $this->result = $this->serializer->deserialize(
            $this->request->getResponse()->getBody(true),
            $this->getOperation()->getResponseClass(),
            'json'
        );
    }
}
