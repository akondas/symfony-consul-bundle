<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $default = [
            'service' => [
                'name' => 'symfony-app',
                'host' => 'localhost',
                'port' => 8000,
            ],
            'client' => [
                'base_uri' => 'http://127.0.0.1:8500',
            ],
        ];

        $treeBuilder = new TreeBuilder('consul');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();
        $rootNode->children()
            ->arrayNode('service')
                ->addDefaultsIfNotSet()
                ->treatNullLike($default['service'])
                ->children()
                    ->scalarNode('name')->defaultValue($default['service']['name'])->end()
                    ->scalarNode('host')->defaultValue($default['service']['host'])->end()
                    ->integerNode('port')->defaultValue($default['service']['port'])->end()
                ->end()
            ->end()
            ->arrayNode('client')
                ->addDefaultsIfNotSet()
                ->treatNullLike($default['client'])
                ->children()
                    ->scalarNode('base_uri')->defaultValue($default['client']['base_uri'])->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
