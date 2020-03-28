<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Tests\Unit\Command;

use Akondas\ConsulBundle\Command\RegisterServiceCommand;
use Akondas\ConsulBundle\Service\ConsulAgent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class RegisterServiceCommandTest extends TestCase
{
    public function testRegisterCommand(): void
    {
        $mock = $this->createMock(ConsulAgent::class);

        $tester = new CommandTester(new RegisterServiceCommand($mock, 'symfony-app', 'localhost', 8000));
        $tester->execute([]);

        $lines = explode(PHP_EOL, $tester->getDisplay());

        self::assertEquals('Service symfony-app registered in Consul', $lines[0]);
    }
}
