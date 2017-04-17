<?php

/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\BehaviorExtension\Console\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\{
    InputArgument,
    InputOption,
    InputInterface
};

use Tidal\PhpSpec\ConsoleExtension\Command\GenericInlineConfigCommand;
use Tidal\PhpSpec\ConsoleExtension\Contract\Command\InlineConfigCommandInterface;

use Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command\{
    UsesInterfaceTrait,
    UsesBehaviorTrait
};

/**
 * class Tidal\PhpSpec\Behavior\Command\ImplementCommand
 */
class ImplementCommand extends GenericInlineConfigCommand implements InlineConfigCommandInterface
{
    use
        UsesInterfaceTrait,
        UsesBehaviorTrait;

    /**
     * CONFIG
     */
    public const NAME = 'behavior:implement';
    public const DESCRIPTION = 'Creates a Trait from a given Interface';
    public const HIDDEN = false;
    public const USAGES = [ '@todo' ];
    public const HELP = <<<EOF
The <info>%command.name%</info> command creates an trait from a given interface:
  <info>php %command.full_name% ClassName MethodName</info>
Will generate an example in the ClassNameSpec.
EOF;

    public const ARGUMENTS = [
        self::INTERFACE_INPUT => [
            self::MODE_KEY => InputArgument::REQUIRED,
            self::DESCRIPTION_KEY => 'Interface to create behavior for'
        ],
        self::TRAIT_INPUT => [
            self::MODE_KEY => InputArgument::OPTIONAL,
            self::DESCRIPTION_KEY => 'Custom trait class name'
        ]
    ];

    public const OPTIONS = [
        self::FORCE_KEY => [
            self::MODE_KEY => InputOption::VALUE_NONE,
            self::DESCRIPTION_KEY => 'Force creation of Trait without asking for confirmation'
        ]
    ];

    protected const CONFIRMATION_QUESTION = 'Do you want to generate a Trait for Interface %s?';

    protected const INTERFACE_INPUT = 'interface';
    protected const TRAIT_INPUT = 'trait';

    protected const MODE_KEY = 'mode';
    protected const DESCRIPTION_KEY = 'description';
    protected const FORCE_KEY = 'force';

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $interfaceName = $input->getArgument(self::INTERFACE_INPUT);
        try {
            $this->demandInterface($interfaceName);
        } catch (\Throwable $e) {
            return 1;
        }

        $traitName = $input->getArgument(self::TRAIT_INPUT);

        if (!$this->validateTrait($traitName) && !$input->getOption(self::FORCE_KEY)) {
            return 0;
        }


        if (!$this->confirmTraitGeneration($interfaceName, $traitName)) {
            return 0;
        }

        return 0;
    }

    /**
     * @param string $interfaceName
     * @param null|string $traitName
     * @return bool
     */
    private function confirmTraitGeneration(string $interfaceName, ? string $traitName)
    {
        return $this->getWriter()->confirm(
            self::CONFIRMATION_QUESTION,
            [
                $interfaceName,
                $traitName
            ]
        );
    }
}

