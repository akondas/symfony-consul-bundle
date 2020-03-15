<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class ConsulExtension extends Extension
{
    /**
     * @param mixed[] $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('consul.agent.base_uri', $config['client']['base_uri']);
        $container->setParameter('consul.service.name', $config['service']['name']);
        $container->setParameter('consul.service.host', $config['service']['host']);
        $container->setParameter('consul.service.port', $config['service']['port']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
