<?php
/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace spec\Tidal\PhpSpec\Behavior\Command;

use Tidal\PhpSpec\Behavior\Command\ImplementCommand;
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

    private const CONFIG = [
        'NAME' => ImplementCommand::NAME,
        'DESCRIPTION' => ImplementCommand::DESCRIPTION,
        'HELP' => ImplementCommand::HELP
    ];


    function it_is_initializable()
    {
        $this->shouldHaveType(ImplementCommand::class);
    }

    function it_is_a_symfony_command()
    {
        $this->shouldHaveType(Command::class);
    }

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

    private function shouldReturnConstant(string $value, string $key = ''): bool
    {
        return array_key_exists($key, self::CONFIG) ?? self::CONFIG[$key] === $value;
    }

    private function shouldHaveConsoleArgument(InputDefinition $inputDefinition, $name = ''): bool
    {
        return $inputDefinition->hasArgument($name);
    }

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
