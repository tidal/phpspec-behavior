<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace features\Behavior\Context\Console;

use Prophecy\Argument;

/**
 * Class features\Behavior\Context\Console\PromptContextTrait */
trait PromptContextTrait
{
    /**
     * @Given I get prompted and answer yes
     */
    public function iGetPromptedAndAnswerYes()
    {
        $this->getWriterProphecy()
            ->confirm(
                Argument::type('string'),
                Argument::any(),
                Argument::any()
            )->willReturn(
                true
            );
    }

    /**
     * @Given I get prompted and answer no
     */
    public function iGetPromptedAndAnswerNo()
    {
        $this->getWriterProphecy()
            ->confirm(
                Argument::type('string'),
                Argument::any(),
                Argument::any()
            )->willReturn(
                false
            );
    }

    /**
     * @Then I get prompted
     */
    public function iGetPrompted()
    {
        $this->getWriterProphecy()
            ->confirm(
                Argument::type('string'),
                Argument::any(),
                Argument::any()
            )->shouldHaveBeenCalled();
    }

    /**
     * @Then I do not get prompted
     */
    public function iDoNotGetPrompted()
    {
        $this->getWriterProphecy()
            ->confirm(
                Argument::type('string'),
                Argument::any(),
                Argument::any()
            )->shouldNotHaveBeenCalled();
    }
}

