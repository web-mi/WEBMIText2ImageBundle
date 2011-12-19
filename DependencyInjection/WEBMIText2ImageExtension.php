<?php

namespace WEBMI\Bundle\Text2ImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class WEBMIText2ImageExtension extends Extension
{
    /**
     * Handles the webmi_text2image configuration.
     *
     * @param array $configs The configurations being loaded
     * @param ContainerBuilder $container
     */
    public function load(array $configs , ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->process($configuration->getConfigTree(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parser.xml');
        $loader->load('helper.xml');
        $loader->load('twig.xml');

        $container->setAlias('text2image.parser', $config['parser']['service']);
    }
}
