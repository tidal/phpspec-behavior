<?php

/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension;

use PhpSpec\Extension as ExtensionInterface;
use PhpSpec\ServiceContainer;
use PhpSpec\Console\ConsoleIO;
use Tidal\PhpSpec\BehaviorExtension\Console\Command\{
    ImplementCommand
};
use Tidal\PhpSpec\ConsoleExtension\Writer;
use Tidal\PhpSpec\ConsoleExtension\Command\InlineConfigurator;
use Symfony\Component\Console\Command\Command;

/**
 * class Tidal\PhpSpec\BehaviorExtension\Behavior\Extension
 */
class Extension implements ExtensionInterface
{
    private const IMPLEMENT_KEY = 'implement';

    public const COMMAND_IDS = [
        self::IMPLEMENT_KEY => 'console.commands.behavior_implement'
    ];

    private const IO_ID = 'console.io';

    /**
     * @var ImplementCommand
     */
    private $implementCommand;

    /**
     * @param ServiceContainer $container
     * @param array            $params
     */
    public function load(ServiceContainer $container, array $params)
    {
        $this->registerCommands($container);
    }

    private function registerCommands(ServiceContainer $container)
    {
        $this->registerImplementCommand($container);
    }

    private function registerImplementCommand(ServiceContainer $container)
    {
        $container->define(
            self::COMMAND_IDS[ self::IMPLEMENT_KEY ],
            function() use ($container) {
                /** @var ImplementCommand $command */
                $command = $this->getImplementCommand(
                    self::retrieveConsoleWriter($container),
                    self::createConfigurator()
                );
                $command->setContainer($container);

                return $command;
            },
            ['console.commands']
        );
    }

    /**
     * @param Command $implementCommand
     */
    public function setImplementCommand(Command $implementCommand)
    {
        $this->implementCommand = $implementCommand;
    }

    /**
     * @param Writer $writer
     * @return ImplementCommand
     */
    public function getImplementCommand(Writer $writer, InlineConfigurator $configurator): ImplementCommand
    {
        return isset($this->implementCommand)
            ? $this->implementCommand
            : $this->implementCommand = self::createImplementCommand($writer, $configurator);
    }

    /**
     * @param Writer $writer
     * @return ImplementCommand
     */
    private static function createImplementCommand(Writer $writer, InlineConfigurator $configurator): ImplementCommand
    {
        return new ImplementCommand($writer, $configurator);
    }

    /**
     * @param ServiceContainer $container
     * @return Writer
     */
    private static function retrieveConsoleWriter(ServiceContainer $container)
    {
        return self::createConsoleWriter(
            self::retrieveConsoleIo($container)
        );
    }

    /**
     * @param ConsoleIO $io
     * @return Writer
     */
    private static function createConsoleWriter(ConsoleIO $io)
    {
        $writer = new Writer();
        $writer->setConsoleIO($io);

        return $writer;
    }

    /**
     * @return InlineConfigurator
     */
    private static function createConfigurator()
    {
        return new InlineConfigurator();
    }

    /**
     * @param ServiceContainer $container
     * @return object|ConsoleIO
     */
    private static function retrieveConsoleIo(ServiceContainer $container)
    {
        return $container->get(self::IO_ID);
    }
}

