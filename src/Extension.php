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
    ] ;

    private const IO_ID = 'console.io';

    /**
     * @var Command
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
        $container->define(
            self::COMMAND_IDS[self::IMPLEMENT_KEY],
            function () use ($container) {
                return $this->getImplementCommand(
                    self::retrieveConsoleWriter($container),
                    self::createConfigurator()
                );
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
     * @return Command
     */
    public function getImplementCommand(Writer $writer, InlineConfigurator $configurator): Command
    {
        return isset($this->implementCommand)
            ? $this->implementCommand
            : $this->implementCommand = self::createImplementCommand($writer, $configurator);
    }

    /**
     * @param Writer $writer
     * @return ImplementCommand
     */
    private static function createImplementCommand(Writer $writer, InlineConfigurator $configurator)
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
        return new Writer($io);
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

