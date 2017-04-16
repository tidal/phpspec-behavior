<?php

/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\Behavior\Command;

use Symfony\Component\Console\Command\Command;

/**
 * class Tidal\PhpSpec\Behavior\Command\ImplementCommand
 */
class ImplementCommand extends Command
{
    public const NAME = 'behavior:implement';

    public function __construct()
    {
        parent::__construct(self::NAME);
    }
}