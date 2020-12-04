<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\Command\AbstractCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractHandlerController extends AbstractController
{
    public function handler(AbstractCommandHandler $commandHandler, array $request)
    {
        $commandHandler->handler($request);
    }
}