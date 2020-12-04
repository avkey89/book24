<?php

declare(strict_types=1);

namespace App\Services\Command;

interface CommandHandlerInterface
{
    public function handler(array $request): bool;
}