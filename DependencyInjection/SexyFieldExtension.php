<?php
declare (strict_types=1);

namespace Tardigrades\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class SexyFieldExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        (new SectionFieldExtension())->load($configs, $container);
        (new SectionFieldEntityExtension())->load($configs, $container);
        (new SectionFieldDoctrineExtension())->load($configs, $container);
        (new SectionFieldTwigExtension())->load($configs, $container);
        (new SectionFieldApiExtension())->load($configs, $container);
    }
}
