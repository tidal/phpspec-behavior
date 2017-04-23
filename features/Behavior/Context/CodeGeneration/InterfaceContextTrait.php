<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Behavior\Context\CodeGeneration;

use Hamcrest\MatcherAssert as Matcher;

trait InterfaceContextTrait
{
    /**
     * @Given the interface :interfaceName does exist
     *
     * @param $interfaceName
     */
    public function theInterfaceDoesExist($interfaceName)
    {
        $this->assertInterfaceExists($interfaceName);
    }

    /**
     * @Given the interface :interfaceName does not exist
     *
     * @param $interfaceName
     */
    public function theInterfaceDoesNotExist(string $interfaceName)
    {
        $this->assertInterfaceNotExists($interfaceName);
    }

    protected function assertInterfaceExists(string $interfaceName)
    {
        Matcher::assertThat(
            sprintf(
                'interface %s should exist',
                $interfaceName
            ),
            interface_exists($interfaceName)
        );
    }

    protected function assertInterfaceNotExists(string $interfaceName)
    {
        Matcher::assertThat(
            sprintf(
                'interface %s should not exist',
                $interfaceName
            ),
            !interface_exists($interfaceName)
        );
    }
}

