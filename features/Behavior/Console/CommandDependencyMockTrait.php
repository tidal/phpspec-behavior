<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Behavior\Console;

use PhpSpec\Locator\ResourceManager;
use PhpSpec\Locator\Resource;
use PhpSpec\CodeGenerator\GeneratorManager;
use PhpSpec\ServiceContainer;

use Tidal\PhpSpec\ConsoleExtension\Writer;
use Tidal\PhpSpec\ConsoleExtension\Command\InlineConfigurator as Configurator;
use spec\Tidal\PhpSpec\ConsoleExtension\Behavior\Prophecy\HasWriterMockTrait;

use Prophecy\Prophet;
use Prophecy\Argument;
use Prophecy\Prophecy\ProphecyInterface;

use Tidal\PhpSpec\BehaviorExtension\Console\Command\ImplementCommand;


trait CommandDependencyMockTrait
{
    use HasWriterMockTrait;

    /**
     * @var ProphecyInterface
     */
    protected $writerProphecy;

    /**
     * @var Writer
     */
    protected $writer;

    /**
     * @return ImplementCommand
     */
    protected function getPhpspecBehaviorImplementCommand(): ImplementCommand
    {
        $command = new ImplementCommand(
            $this
                ->getWriter(),
            new Configurator(),
            []
        );
        $command->setContainer(
            $this
                ->createContainerProphecy()
                ->reveal()
        );

        return $command;
    }

    /**
     * @return ProphecyInterface
     */
    protected function getWriterProphecy(): ProphecyInterface
    {
        if (!isset($this->writerProphecy)) {
            $this->writerProphecy = $this->createWriterProphecy();
        }

        return isset($this->writerProphecy)
            ? $this->writerProphecy
            : $this->writerProphecy = $this->createWriterProphecy();
    }

    /**
     * @return object|Writer
     */
    protected function getWriter(): Writer
    {
        return isset($this->writer)
            ? $this->writer
            : $this->writer = $this->getWriterProphecy()->reveal();
    }

    /**
     * @return ProphecyInterface
     */
    protected function createGeneratorManagerProphecy(): ProphecyInterface
    {
        $prophecy = (new Prophet)
            ->prophesize();
        $prophecy
            ->willExtend(
                GeneratorManager::class
            )
            ->generate(
                Argument::any(),
                Argument::any(),
                Argument::any()
            )
            ->willReturn(
                $this->createResourceProphecy()
            );

        return $prophecy;
    }

    /**
     * @return ProphecyInterface
     */
    protected function createContainerProphecy(): ProphecyInterface
    {
        $prophecy = (new Prophet)
            ->prophesize()
            ->willImplement(
                ServiceContainer::class
            );
        $prophecy
            ->get(
                'code_generator'
            )
            ->willReturn(
                $this->createGeneratorManagerProphecy()->reveal()
            );
        $prophecy
            ->get(
                'locator.resource_manager'
            )
            ->willReturn(
                $this->createResourceManagerProphecy()->reveal()
            );

        return $prophecy;
    }

    /**
     * @return ProphecyInterface
     */
    protected function createResourceManagerProphecy(): ProphecyInterface
    {
        $prophecy = (new Prophet)
            ->prophesize();
        $prophecy
            ->willImplement(ResourceManager::class)
            ->createResource(
                Argument::type('string')
            )
            ->willReturn(
                $this->createResourceProphecy()->reveal()
            );

        return $prophecy;
    }

    /**
     * @return ProphecyInterface
     */
    protected function createResourceProphecy(): ProphecyInterface
    {
        return (new Prophet)
            ->prophesize()
            ->willImplement(
                Resource::class
            );
    }
}

