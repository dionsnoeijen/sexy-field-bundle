<?php

namespace Tardigrades\Bundle\SexyFieldBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class XmlDriverCompilerPass implements CompilerPassInterface{

    public function process(ContainerBuilder $container)
    {
        $driverChainDef = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $driverChainDef->addMethodCall('addDriver', [
                new Reference('sexy_field.xml_driver'),
                'Tardigrades\\Entity'
            ]
        );
    }

}
