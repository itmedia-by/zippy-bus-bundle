<?php

declare(strict_types=1);

namespace Itmedia\ZippyBusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('itmedia_zippy_bus')
            ->addDefaultsIfNotSet()
            ->children()
            ->integerNode('cache_ttl')->defaultValue(3600)->end()
            ->scalarNode('token')->end()
            ->end();

        return $treeBuilder;
    }
}
