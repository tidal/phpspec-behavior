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

trait TraitContextTrait
{
    /**
     * @Given the interface :traitName does exist
     *
     * @param $traitName
     * @return bool
     */
    public function theTraitDoesExist($traitName)
    {
        Matcher::assertThat(trait_exists($traitName));
    }

    /**
     * @Given the interface :traitName does not exist
     *
     * @param $traitName
     * @return bool
     */
    public function theTraitDoesNotExist($traitName)
    {
        Matcher::assertThat(!trait_exists($traitName));
    }
}

