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

/**
 * class Tidal\PhpSpec\Behavior\Extension
 */
class Extension implements ExtensionInterface
{
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
        $container->define('console.commands.behavior_implement', function () use ($container) {

        });
    }
}
