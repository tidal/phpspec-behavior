<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace spec\Tidal\PhpSpec\Behavior;

use Tidal\PhpSpec\Behavior\Extension;
use PhpSpec\ObjectBehavior;
use PhpSpec\Extension as ExtensionInterface;
use PhpSpec\ServiceContainer;
use Prophecy\Argument;

/**
* class spec\Tidal\PhpSpec\Behavior\ExtensionSpec
*/
class ExtensionSpec extends ObjectBehavior
{
    private const IMPLEMENT_KEY = 'implement';

    public const COMMAND_IDS = [
        self::IMPLEMENT_KEY => 'console.commands.behavior_implement'
    ] ;

    function it_is_initializable()
    {
        $this->shouldHaveType(Extension::class);
    }

    function it_is_a_phpspec_extension()
    {
        $this->shouldImplement(ExtensionInterface::class);
    }

    function it_registers_the_behavior_implement_callback(ServiceContainer $container)
    {
        $this
            ->load($container, []);
        $container
            ->define(self::COMMAND_IDS['implement'], Argument::type('callable'))
            ->shouldHaveBeenCalled();
    }
}
