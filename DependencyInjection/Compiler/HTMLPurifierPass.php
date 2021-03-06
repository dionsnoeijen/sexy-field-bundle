<?php

namespace Tardigrades\Bundle\SexyFieldBundle\DependencyInjection\Compiler;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

class HTMLPurifierPass implements CompilerPassInterface
{
    const PURIFIER_TAG = 'tardigrades.sexy_field.html_purifier';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        try {
            $registry = $container->findDefinition(ContainerInterface::class);
        } catch (ServiceNotFoundException $e) {
            return;
        }

        $purifiers = [];
        foreach ($container->findTaggedServiceIds(self::PURIFIER_TAG) as $id => $tags) {

            if (empty($tags[0]['profile'])) {
                throw new InvalidConfigurationException(
                    sprintf(
                        'Tag "%s" must define a "profile" attribute.',
                        self::PURIFIER_TAG
                    )
                );
            }

            $profile = $tags[0]['profile'];
            $purifier = $container->getDefinition($id);

            if (empty($purifier->getArguments())) {
                $configId = "sexy_field.config.$profile";
                $config = $container->hasDefinition($configId) ? $configId : 'sexy_field.config.default';
                $purifier->addArgument(new Reference($config));
            }

            $purifiers[$profile] = new Reference($id);
        }

        $registry->setArguments([
            ServiceLocatorTagPass::register($container, $purifiers),
        ]);
    }
}
