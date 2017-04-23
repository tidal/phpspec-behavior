<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Behavior\Console;

use PhpSpec\Console\Application as PhpSpecApp;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;

trait ApplicationTestTrait
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * @var ApplicationTester
     */
    protected $applicationTester;

    /**
     * @var string
     */
    protected $applicationName;

    public function setupApplication()
    {
        $this->applicationName = $this->getApplication()->getName();
    }

    /**
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        if (!isset($this->application)) {
            $this->createApplication();
        }

        return $this->application;
    }

    private function createApplication()
    {
        $this->application = new PhpSpecApp('dev');
        $this->application->setAutoExit(false);
    }

    protected function resetApplication()
    {
        $this->application = null;
        $this->applicationTester = null;
    }

    /**
     * @param ApplicationTester $applicationTester
     */
    public function setApplicationTester(ApplicationTester $applicationTester)
    {
        $this->applicationTester = $applicationTester;
    }

    /**
     * @return ApplicationTester
     */
    public function getApplicationTester(): ApplicationTester
    {
        if (!isset($this->applicationTester)) {
            $this->createApplicationTester();
        }

        return $this->applicationTester;
    }

    private function createApplicationTester()
    {
        $this->applicationTester = new ApplicationTester(
            $this->getApplication()
        );
    }
}