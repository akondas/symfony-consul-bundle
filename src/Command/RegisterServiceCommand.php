<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Command;

use Akondas\ConsulBundle\Service\ConsulAgent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RegisterServiceCommand extends Command
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
            ->setName('consul:register')
            ->setDescription('Register this application in Consul')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = 'symfony-app';
        $this->agent->registerService($name, 'localhost', 8000);

        $output->writeln(sprintf('Service %s registered in Consul', $name));

        return 0;
    }
}
