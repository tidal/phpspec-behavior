<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Tidal\PhpSpec\BehaviorExtension\Console\Command;

use spec\Tidal\PhpSpec\BehaviorExtension\Behavior\Command\{
    UsesBehaviorSpecTrait,
    UsesInterfaceSpecTrait
};
use Tidal\PhpSpec\ConsoleExtension\Writer;
use Tidal\PhpSpec\ConsoleExtension\Contract\Command\ConfigInterface as Config;
use Tidal\PhpSpec\ConsoleExtension\Command\InlineConfigurator;
use Tidal\PhpSpec\BehaviorExtension\Console\Command\ImplementCommand;
use spec\Tidal\PhpSpec\BehaviorExtension\Behavior\Command\IsConfigurableSpecTrait;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;

/**
 * class spec\Tidal\PhpSpec\Behavior\Command\ImplementCommandSpec
 *
 * @method ImplementCommandSpec getName()
 * @method ImplementCommandSpec getDescription()
 * @method ImplementCommandSpec getHelp()
 * @method ImplementCommandSpec getDefinition()
 */
class ImplementCommandSpec extends ObjectBehavior
{
    use UsesBehaviorSpecTrait,
        UsesInterfaceSpecTrait,
        IsConfigurableSpecTrait;

    private const CONFIG = [
        'NAME' => ImplementCommand::NAME,
        'DESCRIPTION' => ImplementCommand::DESCRIPTION,
        'HELP' => ImplementCommand::HELP
    ];

    ////////////////////////////////////////////
    ///                SETUP                 ///
    ////////////////////////////////////////////

    function let(Writer $writer)
    {
        $configurator = new InlineConfigurator();
        $config = [
            Config::NAME_KEY => ImplementCommand::NAME,
            Config::DESCRIPTION_KEY => ImplementCommand::DESCRIPTION,
            Config::HELP_KEY => ImplementCommand::HELP,
            Config::HIDDEN_KEY => ImplementCommand::HIDDEN,
            Config::ARGUMENTS_KEY => ImplementCommand::ARGUMENTS,
            Config::OPTIONS_KEY => ImplementCommand::OPTIONS,
        ];
        $configurator->setConfig($config);

        $this->beConstructedWith($writer, $configurator, $config);
    }

    ////////////////////////////////////////////
    ///                TESTS                 ///
    ////////////////////////////////////////////

    //-> CONSTRUCTION <-//

    function it_is_initializable()
    {
        $this->shouldHaveType(ImplementCommand::class);
    }

    function it_is_a_symfony_command()
    {
        $this->shouldHaveType(Command::class);
    }

    //-> CONFIG <-//

    function it_has_a_name()
    {
        $this->getName()->shouldReturnConstant('NAME');
    }

    function it_has_a_description()
    {
        $this->getDescription()->shouldReturnConstant('DESCRIPTION');
    }

    function it_has_help()
    {
        $this->getHelp()->shouldReturnConstant('HELP');
    }

    function it_has_arguments()
    {
        foreach (ImplementCommand::ARGUMENTS as $name => $config) {
            $this->getDefinition()->shouldHaveConsoleArgument($name);
        }
    }

    function it_has_options()
    {
        foreach (ImplementCommand::OPTIONS as $name => $config) {
            $this->getDefinition()->shouldHaveConsoleOption($name);
        }
    }

    ////////////////////////////////////////////
    ///               HELPERS                ///
    ////////////////////////////////////////////

    /**
     * @param string $value
     * @param string $key
     * @return bool
     */
    private function shouldReturnConstant(string $value, string $key = ''): bool
    {
        return array_key_exists($key, self::CONFIG) ?? self::CONFIG[$key] === $value;
    }

    /**
     * @param InputDefinition $inputDefinition
     * @param string $name
     * @return bool
     */
    private function shouldHaveConsoleArgument(InputDefinition $inputDefinition, $name = ''): bool
    {
        return $inputDefinition->hasArgument($name);
    }

    /**
     * @param InputDefinition $inputDefinition
     * @param string $name
     * @return bool
     */
    private function shouldHaveConsoleOption(InputDefinition $inputDefinition, $name = ''): bool
    {
        return $inputDefinition->hasOption($name);
    }

    /**
     * @return callable[]
     */
    public function getMatchers()
    {
        return [
            'returnConstant' => \Closure::fromCallable([$this, 'shouldReturnConstant']),
            'haveConsoleArgument' => \Closure::fromCallable([$this, 'shouldHaveConsoleArgument']),
            'haveConsoleOption' => \Closure::fromCallable([$this, 'shouldHaveConsoleOption']),
        ];
    }
}

