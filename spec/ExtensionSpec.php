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

/**
* class spec\Tidal\PhpSpec\Behavior\ExtensionSpec
*/
class ExtensionSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(Extension::class);
    }
}
