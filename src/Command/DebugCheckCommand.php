<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Command;

use Akondas\ConsulBundle\Service\ConsulAgent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class DebugCheckCommand extends Command
{
    private ConsulAgent $agent;
    private string $serviceName;

    public function __construct(ConsulAgent $agent, string $serviceName)
    {
        $this->agent = $agent;
        $this->serviceName = $serviceName;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('debug:consul-check')
            ->setDescription('Debug consul check')
            ->addOption('name', 'na', InputOption::VALUE_OPTIONAL, 'Service name', $this->serviceName)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $check = $this->agent->check((string) $input->getOption('name'));

        if ($check->status() === 'passing') {
            $output->writeln(sprintf('<fg=green>Status: %s<fg=default>', $check->status()));
        } else {
            $output->writeln(sprintf('<fg=red>Status: %s<fg=default>', $check->status()));
        }
        $output->writeln($check->output());

        return 0;
    }
}
