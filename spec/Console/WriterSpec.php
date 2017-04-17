<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Tidal\PhpSpec\BehaviorExtension\Console;

use spec\Tidal\PhpSpec\BehaviorExtension\Behavior\Command\HasConsoleIOSpecTrait;
use Tidal\PhpSpec\BehaviorExtension\Console\Writer;
use Tidal\PhpSpec\BehaviorExtension\Contract\Console\WriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;

/**
 * class spec\Tidal\PhpSpec\BehaviorExtension\Console\WriterSpec
 *
 * @method MethodProphecy setConsoleIO($io)
 * @method MethodProphecy confirm($message)
 * @method MethodProphecy writeError($message)
 */
class WriterSpec extends ObjectBehavior
{
    use HasConsoleIOSpecTrait;

    function it_is_initializable()
    {
        $this->shouldHaveType(Writer::class);
    }

    function it_is_a_writer()
    {
        $this->shouldImplement(WriterInterface::class);
    }

    function it_can_confirm()
    {
        $io = $this->createIOProphecy();
        /** @var MethodProphecy $confirmation */
        $confirmation = $io->askConfirmation(Argument::containingString('foo'), true);
        $confirmation
            ->shouldBeCalled()
            ->willReturn(true);

        $this->setConsoleIO($io->reveal());

        $this->confirm('foo')->shouldReturn(true);
    }

    function it_can_write_errors()
    {
        $io = $this->createIOProphecy();
        /** @var MethodProphecy $writeLn */
        $writeLn = $io->writeln(Argument::type('string'));
        $writeLn->shouldBeCalled();

        $this->setConsoleIO($io->reveal());

        $this->writeError('foo');
    }
}

