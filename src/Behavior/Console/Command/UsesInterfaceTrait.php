<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command;

use Throwable;
use Tidal\PhpSpec\BehaviorExtension\Exception\NoInterfaceException;
use Tidal\PhpSpec\ConsoleExtension\Contract\WriterInterface;

/**
 * trait Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command\UsesInterfaceTrait
 */
trait UsesInterfaceTrait
{
    /**
     * @param string $interfaceName
     * @return bool
     */
    public function validateInterface(string $interfaceName)
    {
        return interface_exists($interfaceName);
    }

    /**
     * @param string $interfaceName
     */
    public function requireInterface(string $interfaceName)
    {
        if (!$this->validateInterface($interfaceName)) {
            throw new NoInterfaceException($interfaceName);
        }
    }

    /**
     * @param string $interfaceName
     * @throws Throwable
     */
    public function demandInterface(string $interfaceName)
    {
        try {
            $this->requireInterface($interfaceName);
        } catch (Throwable $exception) {
            $this->getWriter()->writeError($exception->getMessage());

            throw $exception;
        }
    }

    /**
     * @param WriterInterface $writer
     */
    abstract public function setWriter(WriterInterface $writer);

    /**
     * @return WriterInterface
     */
    abstract public function getWriter(): WriterInterface;
}
