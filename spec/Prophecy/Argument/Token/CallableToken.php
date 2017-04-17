<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Tidal\PhpSpec\BehaviorExtension\Prophecy\Argument\Token;

use Prophecy\Argument\Token\TokenInterface;

/**
 * class spec\Tidal\PhpSpec\BehaviorExtension\Prophecy\Argument\Token\CallableToken
 */
class CallableToken implements TokenInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * Initializes token.
     *
     * @param callable $callback
     *
     * @throws \Prophecy\Exception\InvalidArgumentException
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Scores 7 if callback returns true, false otherwise.
     *
     * @param $argument
     *
     * @return bool|int
     */
    public function scoreArgument($argument)
    {
        return $this($argument) ? 7 : false;
    }

    /**
     * Returns false.
     *
     * @return bool
     */
    public function isLast()
    {
        return false;
    }

    /**
     * Returns string representation for token.
     *
     * @return string
     */
    public function __toString()
    {
        return 'callback()';
    }

    /**
     * @param $argument
     * @return mixed
     */
    public function __invoke($argument)
    {
        return call_user_func($this->callback, $argument);
    }

    /**
     * @param callable $callback
     * @return CallableToken
     */
    public static function create(callable $callback)
    {
        return new self($callback);
    }
}
