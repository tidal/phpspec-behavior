<?php

/**
 * This file is part of the phpspec-behavior package.
 * (c) 2017 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tidal\PhpSpec\Behavior\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * class Tidal\PhpSpec\Behavior\Command\ImplementCommand
 */
class ImplementCommand extends Command
{
    public const NAME = 'behavior:implement';
    public const DESCRIPTION = 'Creates a Trait from a given Interface';
    public const HELP = <<<EOF
The <info>%command.name%</info> command creates an trait from a given interface:
  <info>php %command.full_name% ClassName MethodName</info>
Will generate an example in the ClassNameSpec.
EOF;

    private const INTERFACE_INPUT = 'interface';
    private const TRAIT_INPUT = 'trait';

    private const MODE_KEY = 'mode';
    private const DESCRIPTION_KEY = 'description';
    private const CONFIRM_KEY = 'confirm';

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
        self::CONFIRM_KEY => [
            self::MODE_KEY => InputOption::VALUE_NONE,
            self::DESCRIPTION_KEY => 'Ask for confirmation before creating trait'
        ]
    ];

    public function __construct()
    {
        parent::__construct(self::NAME);
    }

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription(self::DESCRIPTION)
            ->setDefinition(
                $this->createArguments()
            )
            ->addOption(
                self::CONFIRM_KEY,
                null,
                self::OPTIONS[self::CONFIRM_KEY][self::MODE_KEY],
                self::OPTIONS[self::CONFIRM_KEY][self::DESCRIPTION_KEY]
            )
            ->setHelp(
                self::HELP
            );
    }

    /**
     * @return InputArgument[]
     */
    private function createArguments()
    {
        $arguments = [];
        foreach (self::ARGUMENTS as $name => $argument) {
            $arguments[] = new InputArgument(
                $name,
                $argument[self::MODE_KEY],
                $argument[self::DESCRIPTION_KEY]
            );
        }

        return $arguments;
    }
}

