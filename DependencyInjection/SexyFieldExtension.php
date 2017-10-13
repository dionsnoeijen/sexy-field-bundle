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
use Tardigrades\DependencyInjection\SectionFieldApiExtension;
use Tardigrades\DependencyInjection\SectionFieldDoctrineExtension;
use Tardigrades\DependencyInjection\SectionFieldEntityExtension;
use Tardigrades\DependencyInjection\SexyFieldExtension as BasePackage;
use Tardigrades\DependencyInjection\SexyFieldFormExtension;

class SexyFieldExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator([
                __DIR__.'/../Resources/config'
            ])
        );

        $loader->load('services.yml');
        $loader->load('fieldtypes.yml');

        (new BasePackage())->load($configs, $container);
        (new SectionFieldEntityExtension())->load($configs, $container);
        (new SectionFieldDoctrineExtension())->load($configs, $container);
        (new SexyFieldFormExtension())->load($configs, $container);
        (new SectionFieldApiExtension())->load($configs, $container);
    }
}
