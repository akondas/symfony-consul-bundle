<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Tests\Unit\Command;

use Akondas\ConsulBundle\Command\DebugCheckCommand;
use Akondas\ConsulBundle\Service\ConsulAgent;
use Akondas\ConsulBundle\Service\ConsulAgent\Check;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class DebugCheckCommandTest extends TestCase
{
    public function testPassingCheck(): void
    {
        $mock = $this->createMock(ConsulAgent::class);
        $mock->method('check')->willReturn(new Check('passing', 'HTTP GET /health 200 OK Output: {"status": "UP"}'));

        $tester = new CommandTester(new DebugCheckCommand($mock));
        $tester->execute([]);

        $lines = explode(PHP_EOL, $tester->getDisplay());

        self::assertEquals('Status: passing', $lines[0]);
    }

    public function testFailingCheck(): void
    {
        $mock = $this->createMock(ConsulAgent::class);
        $mock->method('check')->willReturn(new Check('critical', 'HTTP GET /health connection refused'));

        $tester = new CommandTester(new DebugCheckCommand($mock));
        $tester->execute([]);

        $lines = explode(PHP_EOL, $tester->getDisplay());

        self::assertEquals('Status: critical', $lines[0]);
    }
}
