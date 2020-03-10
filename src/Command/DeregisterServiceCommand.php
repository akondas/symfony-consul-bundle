<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Command;

use Akondas\ConsulBundle\Service\ConsulAgent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DeregisterServiceCommand extends Command
{
    private ConsulAgent $agent;

    public function __construct(ConsulAgent $agent)
    {
        parent::__construct();
        $this->agent = $agent;
    }

    protected function configure(): void
    {
        $this
            ->setName('consul:deregister')
            ->setDescription('Deregister this application from Consul')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = 'magic';
        $this->agent->deregisterService($name);

        $output->writeln(sprintf('Service %s deregistered from Consul', $name));

        return 0;
    }
}
