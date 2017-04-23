<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Behavior\Context\Console;

use features\Behavior\Console as ConsoleBehavior;

use Hamcrest\MatcherAssert as Matcher;

trait CommandContextTrait
{
    use ConsoleBehavior\CommandTestTrait,
        PromptContextTrait;

    /**
     * @Transform :command
     *
     * @param $command
     * @return string
     */
    public function castCommand($command)
    {
        return trim((string)$command);
    }

    /**
     * @Given command :command exists in namespace :namespace
     *
     * @param string $command
     * @param null|string $namespace
     */
    public function commandExistsInNamespace(string $command, string $namespace)
    {
        $this->commandExists(
            $this->renderCommandName(
                $command,
                $namespace
            )
        );
    }


    /**
     * @Given command exists :command
     *
     * @param string $commandName
     */
    public function commandExists(string $commandName)
    {
        Matcher::assertThat(
            sprintf(
                "Command '%s' should exist",
                (string)$commandName
            ),
            $this->getApplication()
                ->has(trim((string)$commandName))
        );
    }


    /**
     * @When /^I run "([^"]*)" command$/
     *
     * @param string $name
     */
    public function iRunCommand(string $name)
    {
        $command = $this->getApplication()->find($name);
        $this->getCommandTester()
            ->execute([
                'command' => $command->getName()
            ]);
    }

    /**
     * @Given I provide (the) argument :name with value :value
     * @Given I type argument :name with value :value
     *
     * @param string $name
     * @param string $value
     */
    public function iProvideArgumentWithValue(string $name, string $value)
    {
        $this->addArgument($name, $value);
    }

    /**
     * @Given I provide no Arguments
     */
    public function iProvideNoArguments()
    {
        $this->setArgumentString('');
    }

    /**
     * @When I execute the command
     */
    public function iExecuteTheCommand()
    {
        try {
            $this->lastExitCode = $this->getCommandTester()
                ->execute(
                    $this->getArguments()
                );
        } catch (\Throwable $throwable) {
            $this->lastException = $throwable;
            $this->lastExitCode = 1;
        }
    }

    /**
     * @Then I get no error
     */
    public function iGetNoError()
    {
        $message = isset($this->lastException)
            ? $this->lastException->getMessage()
            : '';

        Matcher::assertThat(
            sprintf(
                "No error should have been thrown, but got : %s",
                $message
            ),
            !isset($this->lastException)
        );
    }

    /**
     * @Then I get an error
     */
    public function iGetAnError()
    {
        echo $this->getCommandTester()->getDisplay();
        Matcher::assertThat(
            isset($this->lastException)
        );
    }

    /**
     * @Then I get an error message
     */
    public function iGetAnErrorMessage()
    {
        echo $this->getCommandTester()->getDisplay();
        Matcher::assertThat(
            isset($this->lastException)
        );
    }

    /**
     * @Then I get no message
     */
    public function iGetNoMessage()
    {
        Matcher::assertThat(
            trim($this->getCommandTester()->getDisplay()) === ''
        );
    }

    /**
     * @Given I use option :optionName
     *
     * @param string $optionName
     */
    public function iUseOption(string $optionName)
    {
        $this->addArgument('--' . $optionName, 1);
    }
}

