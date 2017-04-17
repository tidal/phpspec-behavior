<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension\Console;

use Tidal\PhpSpec\BehaviorExtension\Contract\Console\WriterInterface;
use Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command\HasConsoleIOTrait;

/**
 * class Tidal\PhpSpec\BehaviorExtension\Console\Writer
 */
class Writer implements WriterInterface
{
    use HasConsoleIOTrait;

    /**
     * @param string $pattern
     * @param array $arguments
     * @param bool $default
     * @return bool
     */
    public function confirm(string $pattern, array $arguments = [], bool $default = true): bool
    {
        $message = vsprintf(
            $pattern,
            $arguments
        );

        return $this->getConsoleIO()->askConfirmation(
            $message,
            $default
        );
    }

    /**
     * @param string $message
     */
    public function writeError(string $message): void
    {
        $this->getConsoleIO()->writeln(sprintf(
            '<error> %s </error>',
            str_repeat(' ', strlen($message))
        ));
        $this->getConsoleIO()->writeln(sprintf(
            '<error> %s </error>',
            $message
        ));
        $this->getConsoleIO()->writeln(sprintf(
            '<error> %s </error>',
            str_repeat(' ', strlen($message))
        ));
    }
}

