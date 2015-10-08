<?php

namespace Clarity\YandexOAuthBundle\Manager;

use Guzzle\Service\ClientInterface;
use Clarity\YandexOAuthBundle\Model\Response\BaseResponse;
use Clarity\YandexOAuthBundle\Model\Response\Error;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
abstract class AbstractManager
{
    /**
     * @var \Guzzle\Service\ClientInterface
     */
    protected $client;

    /**
     * @var \Guzzle\Service\Command\CommandInterface
     */
    protected $command = null;

    /**
     * @param \Guzzle\Service\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $commandName
     * @param object $requestData
     * @return \Clarity\YandexOAuthBundle\Model\Response\BaseResponse|mixed
     */
    protected function call($commandName, $requestData)
    {
        $this->command = $this->client->getCommand(
            $commandName,
            (array) $requestData
        );

        return $this->execute();
    }

    /**
     * Execute request to api
     *
     * @return \Clarity\YandexOAuthBundle\Model\Response\BaseResponse|mixed
     * @throws \RuntimeException
     */
    protected function execute()
    {
        if (null === $this->command) {
            throw new \RuntimeException('Guzzle command not initialized');
        }

        try {
            $result = $this->command->execute();
        } catch(\Guzzle\Service\Exception\ValidationException $e) {
            $result = new BaseResponse();
            $result->setError(
                new Error(
                    'Validation schema API Exception', 
                    print_r($e->getErrors(), true)
                )
            );
        } catch(\Guzzle\Common\Exception\RuntimeException $e) {
            $result = new BaseResponse();
            $result->setError(
                new Error(
                    'Guzzle: API request runtime exception', 
                    print_r($e->getMessage(), true)
                )
            );
        } catch(\Exception $e) {
            $result = new BaseResponse();
            $result->setError(
                new Error(
                    'Exception while call API method', 
                    print_r($e->getMessage(), true)
                )
            );
        }

        return $result;
    }
}
