<?php

namespace WEBMI\Bundle\Text2ImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('webmi_text2image', 'array')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('parser')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('service')->cannotBeEmpty()->defaultValue('text2image.parser.max')->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder->buildTree();
    }
}
