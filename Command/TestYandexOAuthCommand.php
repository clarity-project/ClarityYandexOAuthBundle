<?php

namespace Clarity\YandexOAuthBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;

/**
 * @author varloc2000 <varloc2000@gmail.com>
 */
class TestYandexOAuthCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('clarity:yandex:oauth:test');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start ' . $this->getName());

        $this->paymentRequest();
    }

    private function paymentRequest()
    {
        $manager = $this->getContainer()->get('clarity_yandex.oauth.manager');

        $response = $manager->getAuthorizationCode();

        die(var_dump($response));
    }
}
