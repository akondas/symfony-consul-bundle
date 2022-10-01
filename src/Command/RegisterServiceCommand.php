<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Command;

use Akondas\ConsulBundle\Service\ConsulAgent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class RegisterServiceCommand extends Command
{
    private ConsulAgent $agent;
    private string $serviceName;
    private string $serviceHost;
    private int $servicePort;

    public function __construct(ConsulAgent $agent, string $serviceName, string $serviceHost, int $servicePort)
    {
        $this->agent = $agent;
        $this->serviceName = $serviceName;
        $this->serviceHost = $serviceHost;
        $this->servicePort = $servicePort;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('consul:register')
            ->setDescription('Register this application in Consul')
            ->addOption('name', 'na', InputOption::VALUE_OPTIONAL, 'Service name', $this->serviceName)
            ->addOption('host', 'ho', InputOption::VALUE_OPTIONAL, 'Service host', $this->serviceHost)
            ->addOption('port', 'p', InputOption::VALUE_OPTIONAL, 'Service port', $this->servicePort)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption('name');
        $host = $input->getOption('host');
        $port = $input->getOption('port');
        if (!is_string($name)) {
            throw new \InvalidArgumentException('Option \'name\' must be a string.');
        }
        if (!is_string($host)) {
            throw new \InvalidArgumentException('Option \'host\' must be a string.');
        }
        if (!is_numeric($port)) {
            throw new \InvalidArgumentException('Option \'port\' must be numeric.');
        }

        $this->agent->registerService($name, $host, (int) $port);

        $output->writeln(sprintf('Service %s registered in Consul', $name));

        return 0;
    }
}
