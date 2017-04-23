<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Behavior\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

trait CommandTestTrait
{
    use ApplicationTestTrait,
        CommandDependencyMockTrait;

    /**
     * @var Command
     */
    protected $command;

    /** @var  CommandTester */
    protected $commandTester;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var string
     */
    protected $argumentString;

    /**
     * @var \Throwable
     */
    private $lastException;

    /**
     * @var int
     */
    private $lastExitCode = 0;

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
        $this->setCommandTester(
            new CommandTester(
                $command
            )
        );
        $this->getApplication()
            ->add(
                $command
            );

    }

    /**
     * @return Command
     */
    public function getCommand(): Command
    {
        if (!isset($this->command)) {
            $this->setCommand(
                new Command()
            );
        }

        return $this->command;
    }

    /**
     * @param CommandTester $commandTester
     */
    protected function setCommandTester(CommandTester $commandTester)
    {
        $this->commandTester = $commandTester;
    }

    /**
     * @return CommandTester
     */
    public function getCommandTester(): CommandTester
    {
        return $this->commandTester;
    }

    protected function resetCommand()
    {
        $this->command = null;
        $this->commandTester = null;
        $this->arguments = [];
        $this->argumentString = null;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @param string $name
     * @param bool|string|int|float $value
     */
    public function addArgument(string $name, $value)
    {
        $this->arguments[$name] = $value;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param string $argumentString
     */
    public function setArgumentString(string $argumentString)
    {
        $this->argumentString = $argumentString;
    }

    /**
     * @return string
     */
    public function getArgumentString(): string
    {
        return !isset($this->argumentString)
            ? $this->argumentString
            : $this->argumentString = implode(' ', $this->arguments);
    }

    /**
     * @param string $command
     * @param null|string $namespace
     * @return string
     */
    protected function renderCommandName(string $command, ?string $namespace)
    {
        return $namespace === null
            ? $command
            : sprintf(
                '%s:%s',
                $namespace,
                $command
            );
    }
}

