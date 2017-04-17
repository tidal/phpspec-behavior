<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command;

/**
 * trait Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command\UsesBehaviorTrait
 */
trait UsesBehaviorTrait
{
    /**
     * @param string $traitName
     * @return bool
     */
    public function validateTrait(? string $traitName) : bool
    {
        return trait_exists($traitName);
    }
}
