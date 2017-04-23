<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Context\Console\Command;

use Tidal\PhpSpec\BehaviorExtension\Console\Command\ImplementCommand;

use features\Behavior\Context\Console\SelectCommandContextTrait;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Tidal\PhpSpec\ConsoleExtension\Command\InlineConfigurator as Configurator;
use Tidal\PhpSpec\ConsoleExtension\Contract\Command\ConfigInterface as CommandConfig;


class ImplementContext implements Context
{
    use  SelectCommandContextTrait;

    const COMMAND_NAME = 'behavior:implement';

    /**
     * @var ImplementCommand
     */
    private $implementCommand;

    /**
     * @var Configurator
     */
    private $configurator;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @beforeScenario
     */
    public function setup()
    {
        $this->resetApplication();
        $this->resetCommand();
        $this->setupApplication();
        $this->setupCommand();

    }

    private function setupCommand()
    {
        $this->setCommand(
            $this->getImplementCommand()
        );
        $this->getApplication()
            ->add(
                $this->getCommand()
            );
    }


    /**
     * @Given I type a behavior implement command
     * @Given I type a phpspec behavior implement command
     */
    public function iTypeABehaviorImplementCommand()
    {
        $this->setupCommand();
    }

    /**
     * @Given I type a behavior implement command without Arguments
     * @Given I type a phpspec behavior implement command without Arguments
     */
    public function iTypeAPhpspecBehaviorImplementCommandWithoutArguments()
    {
        throw new PendingException();
    }

    /**
     * @return ImplementCommand
     */
    public function getImplementCommand(): ImplementCommand
    {
        if (!isset($this->implementCommand)) {
            $this->createImplementCommand();
        }

        return $this->implementCommand;
    }

    private function createImplementCommand()
    {
        $this->implementCommand = new ImplementCommand(
            $this->getWriter(),
            $this->getConfigurator(),
            [CommandConfig::NAME_KEY => self::COMMAND_NAME]
        );
        $this->implementCommand->setContainer(
            $this->createContainerProphecy()->reveal()
        );
    }

    /**
     * @return Configurator
     */
    public function getConfigurator(): Configurator
    {
        return isset($this->configurator)
            ? $this->configurator
            : $this->configurator = new Configurator();
    }


}
