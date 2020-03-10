<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Command;

use Akondas\ConsulBundle\Service\ConsulAgent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DebugCheckCommand extends Command
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
            ->setName('debug:consul-check')
            ->setDescription('Debug consul check')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = 'magic';
        $check = $this->agent->check($name);

        if ($check->status() === 'passing') {
            $output->writeln(sprintf('<fg=green>Status: %s<fg=default>', $check->status()));
        } else {
            $output->writeln(sprintf('<fg=red>Status: %s<fg=default>', $check->status()));
        }
        $output->writeln($check->output());

        return 0;
    }
}
