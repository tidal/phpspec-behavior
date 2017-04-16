<?php

/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\Behavior;

use PhpSpec\Extension as ExtensionInterface;
use PhpSpec\ServiceContainer;
use Tidal\PhpSpec\Behavior\Command\ImplementCommand;
use Symfony\Component\Console\Command\Command;

/**
 * class Tidal\PhpSpec\Behavior\Extension
 */
class Extension implements ExtensionInterface
{
    private const IMPLEMENT_KEY = 'implement';

    public const COMMAND_IDS = [
        self::IMPLEMENT_KEY => 'console.commands.behavior_implement'
    ] ;

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
        $container->define(self::COMMAND_IDS['implement'], function () use ($container) {
            return $this->implementCommand;
        });
    }

    /**
     * @param Command $implementCommand
     */
    public function setImplementCommand(Command $implementCommand)
    {
        $this->implementCommand = $implementCommand;
    }

    /**
     * @return Command
     */
    public function getImplementCommand(): Command
    {
        return isset($this->implementCommand)
            ? $this->implementCommand
            : $this->implementCommand = new ImplementCommand();
    }
}
