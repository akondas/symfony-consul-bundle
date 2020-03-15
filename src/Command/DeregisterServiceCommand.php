<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Command;

use Akondas\ConsulBundle\Service\ConsulAgent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class DeregisterServiceCommand extends Command
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
            ->setName('consul:deregister')
            ->setDescription('Deregister this application from Consul')
            ->addOption('name', 'na', InputOption::VALUE_OPTIONAL, 'Service name', $this->serviceName)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->agent->deregisterService((string) $input->getOption('name'));

        $output->writeln(sprintf('Service %s deregistered from Consul', (string) $input->getOption('name')));

        return 0;
    }
}
