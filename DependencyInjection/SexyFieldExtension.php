<?php

/*
 * This file is part of the SexyField package.
 *
 * (c) Dion Snoeijen <hallo@dionsnoeijen.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types=1);

namespace Tardigrades\Bundle\SexyFieldBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Tardigrades\Bundle\SexyFieldBundle\DependencyInjection\Compiler\HTMLPurifierPass;
use Tardigrades\DependencyInjection\SectionFieldApiExtension;
use Tardigrades\DependencyInjection\SectionFieldDoctrineExtension;
use Tardigrades\DependencyInjection\SectionFieldEntityExtension;
use Tardigrades\DependencyInjection\SexyFieldExtension as BasePackage;
use Tardigrades\DependencyInjection\SexyFieldFormExtension;

class SexyFieldExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator([
                __DIR__.'/../Resources/config'
            ])
        );

        try {
            $loader->load('services.yml');
            $loader->load('fieldtypes.yml');
        } catch (\Exception $exception) {
            throw $exception;
        }

        // Prepend a default configuration so you don't have to
        // configure sexy-field
        array_unshift($configs, [
            'default' => [
                'Cache.SerializerPath' => '%kernel.cache_dir%/htmlpurifier',
            ],
        ]);

        $configs = $this->processConfiguration(new Configuration(), $configs);

        $serializerPaths = [];
        foreach ($configs as $name => $config) {
            $configId = "sexy_field.config.$name";
            $configDefinition = $container->register($configId, \HTMLPurifier_Config::class)
                ->setPublic(false)
            ;
            if ('default' === $name) {
                $configDefinition
                    ->setFactory([\HTMLPurifier_Config::class, 'create'])
                    ->addArgument($config)
                ;
            } else {
                $configDefinition
                    ->setFactory([\HTMLPurifier_Config::class, 'inherit'])
                    ->addArgument(new Reference('sexy_field.config.default'))
                    ->addMethodCall('loadArray', [$config])
                ;
            }
            $container->register("sexy_field.$name", \HTMLPurifier::class)
                ->addArgument(new Reference($configId))
                ->addTag(HTMLPurifierPass::PURIFIER_TAG, ['profile' => $name])
            ;
            if (isset($config['Cache.SerializerPath'])) {
                $serializerPaths[] = $config['Cache.SerializerPath'];
            }
        }

        $container->setAlias(\HTMLPurifier::class, 'sexy_field.default')
            ->setPublic(false);

        $container->setParameter('sexy_field.cache_warmer.serializer.paths', array_unique($serializerPaths));

        (new BasePackage())->load($configs, $container);
        (new SectionFieldEntityExtension())->load($configs, $container);
        (new SectionFieldDoctrineExtension())->load($configs, $container);
        (new SexyFieldFormExtension())->load($configs, $container);
        (new SectionFieldApiExtension())->load($configs, $container);
    }
}
