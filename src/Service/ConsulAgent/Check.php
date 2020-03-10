<?php

declare(strict_types=1);

namespace Akondas\ConsulBundle\Service\ConsulAgent;

final class Check
{
    private string $status;
    private string $output;

    public function __construct(string $status, string $output)
    {
        $this->status = $status;
        $this->output = $output;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function output(): string
    {
        return $this->output;
    }
}
