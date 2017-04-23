<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Behavior\Context\Console;

use Symfony\Component\Console\Command\Command;

use Hamcrest\MatcherAssert as Matcher;

/**
 * Trait features\Behavior\Context\Console\SelectCommandContextTrait */
trait SelectCommandContextTrait
{
    use CommandContextTrait;

    /**
     * @var Command
     */
    protected $selectedCommand;


    /**
     * @Given I select command :command in namespace :namespace
     *
     * @param string $command
     * @param null|string $namespace
     */
    public function iSelectCommandInNamespace(string $command, ?string $namespace)
    {
        $this->selectedCommand = $this->getApplication()
            ->find(
                $this->renderCommandName(
                    $command,
                    $namespace
                )
            );
    }

    /**
     * @Given selected command has argument :argument
     *
     * @param string $argument
     */
    public function selectedCommandHasArgument(string $argument)
    {
        $this->assertSelectedCommand();

        Matcher::assertThat(
            sprintf(
                "selected command should have argument '%s'",
                $argument
            ),
            $this->selectedCommand
                ->getDefinition()
                ->hasArgument($argument)
        );
    }

    /**
     * @Given selected command has option :option
     *
     * @param string $option
     */
    public function selectedCommandHasOption(string $option)
    {
        $this->assertSelectedCommand();

        Matcher::assertThat(
            sprintf(
                "selected command should have option '%s'",
                $option
            ),
            $this->selectedCommand
                ->getDefinition()
                ->hasOption($option)
        );
    }

    protected function assertSelectedCommand()
    {
        Matcher::assertThat(
            'A command should be selected',
            isset($this->selectedCommand)
        );
    }

}