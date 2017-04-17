<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command;

use PhpSpec\Console\ConsoleIO;

/**
 * trait Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command\HasConsoleIOTrait
 */
trait HasConsoleIOTrait
{
    /**
     * @var ConsoleIO
     */
    private $consoleIO;

    /**
     * @param ConsoleIO $consoleIO
     */
    public function setConsoleIO(ConsoleIO $consoleIO)
    {
        $this->consoleIO = $consoleIO;
    }

    /**
     * @return ConsoleIO
     */
    public function getConsoleIO()
    {
        return $this->consoleIO;
    }
}

