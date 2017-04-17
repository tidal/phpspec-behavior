<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension\Exception;

use RuntimeException;
use Throwable;

class NoInterfaceException extends RuntimeException
{
    private const MESSAGE_PATTERN = 'Argument is not an interface. Given : %s';

    public function __construct(string $interfaceName, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            self::generateMessage($interfaceName),
            $code,
            $previous
        );
    }

    /**
     * @param string $interfaceName
     * @return string
     */
    private static function generateMessage(string $interfaceName)
    {
        return (sprintf(
            self::MESSAGE_PATTERN,
            $interfaceName
        ));
    }
}
