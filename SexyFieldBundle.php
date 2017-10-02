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

namespace Tardigrades\Bundle\SexyFieldBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tardigrades\Bundle\SexyFieldBundle\DependencyInjection\Compiler\XmlDriverCompilerPass;

class SexyFieldBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new XmlDriverCompilerPass());
    }

    public function registerCommands(Application $application)
    {
        $application->addCommands([
            $this->container->get('section_field.create.application.command'),
            $this->container->get('section_field.update.application.command'),
            $this->container->get('section_field.delete.application.command'),
            $this->container->get('section_field.list.application.command'),
            $this->container->get('section_field.create.language.command'),
            $this->container->get('section_field.update.language.command'),
            $this->container->get('section_field.delete.language.command'),
            $this->container->get('section_field.list.language.command'),
            $this->container->get('section_field.install.field.type.command'),
            $this->container->get('section_field.update.field.type.command'),
            $this->container->get('section_field.delete.field.type.command'),
            $this->container->get('section_field.list.field.type.command'),
            $this->container->get('section_field.create.section.command'),
            $this->container->get('section_field.update.section.command'),
            $this->container->get('section_field.restore.section.command'),
            $this->container->get('section_field.delete.section.command'),
            $this->container->get('section_field.list.section.command'),
            $this->container->get('section_field.generate.section.command'),
            $this->container->get('section_field.create.field.command'),
            $this->container->get('section_field.update.field.command'),
            $this->container->get('section_field.delete.field.command'),
            $this->container->get('section_field.list.field.command')
        ]);

        return parent::registerCommands($application);
    }
}
