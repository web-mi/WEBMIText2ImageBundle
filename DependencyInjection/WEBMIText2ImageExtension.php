<?php

namespace WEBMI\Bundle\Text2ImageBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class WEBMIText2ImageExtension extends Extension {

    public function load(array $config, ContainerBuilder $container) {
        $definition = new Definition('WEBMI\Bundle\Text2ImageBundle\Twig\Extension\Text2ImageTwigExtension');
        // this is the most important part. Later in the startup process TwigBundle
        // searches through the container and registres all services taged as twig.extension.
        $definition->addTag('twig.extension');
        
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
    }

    /**
     * Was necessary in previous Symfony2 PR releases.
     * Symfony2 calls `load` method automatically now.
     *
     * public function getAlias() {
     *     return 'hello'; // that's how we'll call this extension in configuration files
     * }
     */
}