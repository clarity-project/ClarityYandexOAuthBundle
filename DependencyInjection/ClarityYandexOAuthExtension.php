<?php

namespace Clarity\YandexOAuthBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ClarityYandexOAuthExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // Prepare parameters for yandex oauth guzzle client
        $container->setParameter(
            'clarity_yandex.oauth.client.service_description.file_path',
            __DIR__ . '/../Resources/config/client/yandexoauth.json'
        );

        $container->setParameter('clarity_yandex_oauth.apps', $config['apps']);
        $container->setParameter('clarity_yandex_oauth.default_redirect_route', $config['default_redirect_route']);
    }
}
