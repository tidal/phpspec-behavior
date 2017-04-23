<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Tidal\PhpSpec\BehaviorExtension\Behavior\Command;

use Tidal\PhpSpec\BehaviorExtension\Exception\NoInterfaceException;
use Tidal\PhpSpec\ConsoleExtension\Writer;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\{
    Argument,
    Prophet
};

interface Bar
{
}

trait UsesInterfaceSpecTrait
{
    function it_accepts_existing_interfaces()
    {
        $this
            ->validateInterface(Bar::class)
            ->shouldReturn(true);
    }

    function it_rejects_non_existing_interfaces()
    {
        $this
            ->validateInterface('foo')
            ->shouldReturn(false);
    }

    function it_does_not_throw_exception_when_requiring_existing_interfaces()
    {
        $this
            ->shouldNotThrow(NoInterfaceException::class)
            ->during('requireInterface', array(Bar::class));
    }

    function it_throws_exception_when_requiring_non_existing_interfaces()
    {
        $this
            ->shouldThrow(NoInterfaceException::class)
            ->during('requireInterface', array('foo'));
    }

    function it_does_not_write_error_when_demanding_existing_interfaces()
    {
        $prophecy = $this->createWriterProphecy();
        $prophecy->writeError(Argument::type('string'))
            ->shouldNotBeCalled();

        $this->setWriter(
            $prophecy->reveal()
        );

        $this
            ->shouldNotThrow(NoInterfaceException::class)
            ->during('demandInterface', array(Bar::class));
    }

    function it_writes_error_when_demanding_non_existing_interfaces()
    {
        $prophecy = $this->createWriterProphecy();
        $prophecy->writeError(Argument::type('string'))->shouldBeCalled();

        $this->setWriter(
            $prophecy->reveal()
        );

        $this
            ->shouldThrow(NoInterfaceException::class)
            ->during('requireInterface', array('foo'));
    }

    /**
     * @return ObjectProphecy
     */
    private function createWriterProphecy()
    {
        $prophet = new Prophet;
        return $prophet->prophesize()->willExtend(Writer::class);
    }
}