<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Service\ConsulAgent;

use Akondas\ConsulBundle\Exception\ConsulAgentException;
use Akondas\ConsulBundle\Service\ConsulAgent;
use SensioLabs\Consul\Services\Agent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

final class SensioLabsConsulAgent implements ConsulAgent
{
    private Agent $agent;
    private UrlGeneratorInterface $router;

    public function __construct(Agent $agent, UrlGeneratorInterface $router)
    {
        $this->agent = $agent;
        $this->router = $router;
    }

    public function registerService(string $id, string $host, int $port): void
    {
        try {
            $this->router->setContext(new RequestContext('', 'GET', $host, 'http', $port, $port));
            $this->agent->registerService([
                'Name' => $id,
                'Address' => $host,
                'Port' => $port,
                'Check' => [
                    'Interval' => '10s',
                    'Timeout' => '3s',
                    'HTTP' => $this->router->generate('consul_health_check', [], UrlGeneratorInterface::ABSOLUTE_URL),
                ],
            ]);
        } catch (\Throwable $exception) {
            throw new ConsulAgentException(sprintf('Register service failed: %s', $exception->getMessage()));
        }
    }

    public function deregisterService(string $id): void
    {
        try {
            $this->agent->deregisterService($id);
        } catch (\Throwable $exception) {
            throw new ConsulAgentException(sprintf('Deregister service failed: %s', $exception->getMessage()));
        }
    }

    public function check(string $serviceId): Check
    {
        try {
            $json = $this->agent->checks()->json();
            if (!isset($json['service:'.$serviceId])) {
                throw new \RuntimeException(sprintf('Missing check for service %s', $serviceId));
            }
            $check = $json['service:'.$serviceId];

            return new Check(
                $check['Status'],
                $check['Output']
            );
        } catch (\Throwable $exception) {
            throw new ConsulAgentException(sprintf('Failed to fetch check: %s', $exception->getMessage()));
        }
    }
}
