<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Tidal\PhpSpec\BehaviorExtension\Behavior\Command;


trait Foo
{
}

trait UsesBehaviorSpecTrait
{
    function it_accepts_existing_traits()
    {
        $this
            ->validateTrait(Foo::class)
            ->shouldReturn(true);
    }

    function it_rejects_not_existing_traits()
    {
        $this
            ->validateTrait('foo')
            ->shouldReturn(false);
    }
}