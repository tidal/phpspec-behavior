<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace spec\Tidal\PhpSpec\Behavior\Command;

use Tidal\PhpSpec\Behavior\Command\ImplementCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
* class spec\Tidal\PhpSpec\Behavior\Command\ImplementCommandSpec
*/
class ImplementCommandSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(ImplementCommand::class);
    }
}
