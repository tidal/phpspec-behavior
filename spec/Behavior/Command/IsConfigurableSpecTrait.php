<?php
/**
 * This file is part of the DEPH package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Tidal\PhpSpec\BehaviorExtension\Behavior\Command;

use spec\Tidal\PhpSpec\BehaviorExtension\Behavior\Prophecy\HasConfiguratorMockTrait;


trait IsConfigurableSpecTrait
{
    use HasConfiguratorMockTrait;

    function its_configurator_is_accessible()
    {
        $configurator = $this->createConfiguratorMock();

        $this->setConfigurator($configurator);
        $this->getConfigurator()->shouldReturn($configurator);
    }
}
