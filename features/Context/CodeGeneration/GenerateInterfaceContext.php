<?php

namespace features\Context\CodeGeneration;

use features\Behavior\Context\CodeGeneration\InterfaceContextTrait;
use features\Behavior\Console\ApplicationTestTrait;

use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class GenerateInterfaceContext implements Context
{
    use InterfaceContextTrait,
        ApplicationTestTrait;

    /**
     * Initializes context.
     */
    public function __construct()
    {
    }

    /**
     * @beforeScenario
     */
    public function setup()
    {
        $this->setupApplication();
    }

    /**
     * @Given I have started implementing the :interface interface
     * @Given I start implementing the :interface interface
     */
    public function iImplementTheInterface($interface)
    {
        $arguments = array(
            'command' => 'behavior:implement',
            'interface' => $interface
        );
        if ($this->applicationTester->run($arguments, []) !== 0) {
            throw new \Exception('Test runner exited with an error ');
        }
    }
}

