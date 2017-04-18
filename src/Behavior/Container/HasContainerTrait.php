<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension\Behavior\Container;

use PhpSpec\ServiceContainer;

/**
 * trait Tidal\PhpSpec\BehaviorExtension\Behavior\Container\HasContainerTrait
 */
trait HasContainerTrait
{
    /**
     * @var ServiceContainer
     */
    private $container;

    /**
     * @param ServiceContainer $container
     */
    public function setContainer(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @return ServiceContainer
     */
    public function getContainer(): ServiceContainer
    {
        return $this->container;
    }
}

