<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Service;

use Akondas\ConsulBundle\Service\ConsulAgent\Check;

interface ConsulAgent
{
    public function registerService(string $id, string $host, int $port): void;

    public function deregisterService(string $id): void;

    public function check(string $serviceId): Check;
}
