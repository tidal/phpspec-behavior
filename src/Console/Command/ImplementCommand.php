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
use Tidal\PhpSpec\ConsoleExtension\Contract\Command\ConfiguratorInterface;
use Tidal\PhpSpec\ConsoleExtension\Contract\Command\InlineConfigCommandInterface;
use Tidal\PhpSpec\ConsoleExtension\Contract\Command\ConfigInterface as Config;

use Tidal\PhpSpec\BehaviorExtension\Behavior\Console\Command\{
    UsesInterfaceTrait,
    UsesBehaviorTrait,
    CommandTrait
};

use PhpSpec\Locator\ResourceManager;
use PhpSpec\CodeGenerator\GeneratorManager;
use Tidal\PhpSpec\ConsoleExtension\Contract\WriterInterface;

/**
 * class Tidal\PhpSpec\Behavior\Command\ImplementCommand
 */
class ImplementCommand extends GenericInlineConfigCommand implements InlineConfigCommandInterface
{
    use
        UsesInterfaceTrait,
        UsesBehaviorTrait,
        CommandTrait;

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
            Config::MODE_KEY => InputArgument::REQUIRED,
            Config::DESCRIPTION_KEY => 'Interface to create behavior for'
        ],
        self::TRAIT_INPUT => [
            Config::MODE_KEY => InputArgument::OPTIONAL,
            Config::DESCRIPTION_KEY => 'Custom trait class name'
        ]
    ];

    public const OPTIONS = [
        self::FORCE_KEY => [
            Config::MODE_KEY => InputOption::VALUE_NONE,
            Config::DESCRIPTION_KEY => 'Force creation of Trait without asking for confirmation',
            Config::SHORTCUT_KEY => 'f'
        ],
        self::QUITE_KEY => [
            Config::MODE_KEY => InputOption::VALUE_NONE,
            Config::DESCRIPTION_KEY => 'Force creation of Trait without asking for confirmation'
        ]
    ];

    protected const INTERFACE_CONFIRMATION_QUESTION = 'Interface %s? does not exist. Do you want to generate it?';
    protected const TRAIT_CONFIRMATION_QUESTION = 'Do you want to generate a Trait for Interface %s?';

    protected const INTERFACE_INPUT = 'interface';
    protected const TRAIT_INPUT = 'trait';

    protected const FORCE_KEY = 'force';
    protected const QUITE_KEY = 'quite';
    protected const INTERFACE_KEY = 'interface';

    protected const RESOURCE_MANAGER_ID = 'locator.resource_manager';
    protected const GENERATOR_MANAGER_ID = 'code_generator';

    /**
     * @var string
     */
    protected $interfaceName;

    public function __construct(WriterInterface $writer, ConfiguratorInterface $configurator, $config = [])
    {
        $config['name'] = self::NAME;
        parent::__construct($writer, $configurator, $config);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setPuts($input, $output);

        $this->configureContainer();

        $this->ensureInterfaceExists();

        return 0;
    }

    /**
     * @return bool
     */
    private function confirmInterfaceGeneration()
    {
        if ((bool)$this->getInput()->getOption(self::FORCE_KEY)) {
            return true;
        }

        return $this->getWriter()->confirm(
            self::INTERFACE_CONFIRMATION_QUESTION,
            [
                $this->getInput()->getArgument(self::INTERFACE_INPUT)
            ]
        );
    }

    /**
     * @return object|ResourceManager
     */
    protected function retrieveResourceManager()
    {
        return $this->getContainer()->get(self::RESOURCE_MANAGER_ID);
    }

    /**
     * @return object|GeneratorManager
     */
    protected function retrieveGeneratorManager()
    {
        return $this->getContainer()->get(self::GENERATOR_MANAGER_ID);
    }

    protected function ensureInterfaceExists()
    {
        if (!$this->validateInterfaceInput() && $this->confirmInterfaceGeneration()) {
            $this->createInterface();
        }
    }

    protected function createInterface()
    {
        $this->retrieveGeneratorManager()->generate(
            $this->retrieveResourceManager()->createResource(
                $this->getInterfaceName()
            ),
            self::INTERFACE_KEY
        );
    }

    protected function getInterfaceInput(InputInterface $input)
    {
        return $input->getArgument(self::INTERFACE_INPUT);
    }

    protected function validateInterfaceInput()
    {
        return $this->validateInterface(
            $this->getInterfaceInput(
                $this->getInput()
            )
        );
    }

    /**
     * @param string $interfaceName
     */
    protected function setInterfaceName(string $interfaceName)
    {
        $this->interfaceName = $interfaceName;
    }

    /**
     * @return string
     */
    protected function getInterfaceName(): string
    {
        return isset($this->interfaceName)
            ? $this->interfaceName
            : $this->interfaceName = $this->getInput()
                ->getArgument(self::INTERFACE_INPUT);
    }
}

