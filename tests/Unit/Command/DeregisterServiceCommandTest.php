<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Tests\Unit\Command;

use Akondas\ConsulBundle\Command\DeregisterServiceCommand;
use Akondas\ConsulBundle\Service\ConsulAgent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class DeregisterServiceCommandTest extends TestCase
{
    public function testDeregisterCommand(): void
    {
        $mock = $this->createMock(ConsulAgent::class);

        $tester = new CommandTester(new DeregisterServiceCommand($mock, 'symfony-app'));
        $tester->execute([]);

        $lines = explode(PHP_EOL, $tester->getDisplay());

        self::assertEquals('Service symfony-app deregistered from Consul', $lines[0]);
    }
}
