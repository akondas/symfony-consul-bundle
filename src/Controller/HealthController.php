<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class HealthController
{
    /**
     * @Route("/health", name="consul_health_check", methods={"GET"})
     */
    public function check(): JsonResponse
    {
        return new JsonResponse(['status' => 'UP']);
    }
}
