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
use Symfony\Component\Console\Command\Command;
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

    function it_is_a_symfony_command()
    {
        $this->shouldHaveType(Command::class);
    }
}
