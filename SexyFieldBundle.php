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
            $this->container->get('Tardigrades\Command\CreateApplicationCommand'),
            $this->container->get('Tardigrades\Command\UpdateApplicationCommand'),
            $this->container->get('Tardigrades\Command\DeleteApplicationCommand'),
            $this->container->get('Tardigrades\Command\ListApplicationCommand'),
            $this->container->get('Tardigrades\Command\CreateLanguageCommand'),
            $this->container->get('Tardigrades\Command\UpdateLanguageCommand'),
            $this->container->get('Tardigrades\Command\DeleteLanguageCommand'),
            $this->container->get('Tardigrades\Command\ListLanguageCommand'),
            $this->container->get('Tardigrades\Command\InstallFieldTypeCommand'),
            $this->container->get('Tardigrades\Command\UpdateFieldTypeCommand'),
            $this->container->get('Tardigrades\Command\DeleteFieldTypeCommand'),
            $this->container->get('Tardigrades\Command\ListFieldTypeCommand'),
            $this->container->get('Tardigrades\Command\CreateSectionCommand'),
            $this->container->get('Tardigrades\Command\UpdateSectionCommand'),
            $this->container->get('Tardigrades\Command\UpdateSectionsCommand'),
            $this->container->get('Tardigrades\Command\RestoreSectionCommand'),
            $this->container->get('Tardigrades\Command\DeleteSectionCommand'),
            $this->container->get('Tardigrades\Command\ListSectionCommand'),
            $this->container->get('Tardigrades\Command\GenerateSectionCommand'),
            $this->container->get('Tardigrades\Command\CreateFieldCommand'),
            $this->container->get('Tardigrades\Command\UpdateFieldCommand'),
            $this->container->get('Tardigrades\Command\DeleteFieldCommand'),
            $this->container->get('Tardigrades\Command\ListFieldCommand'),
            $this->container->get('Tardigrades\Command\InstallDirectoryCommand')
        ]);

        return parent::registerCommands($application);
    }
}
