<?php

namespace App\Controller;

use App\Transaction\Handler;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction", methods={"POST"}, name="transaction")
     * @param Handler $handler
     * @return JsonResponse
     */
    public function transaction(Handler $handler): JsonResponse
    {
        return $handler->execution();
    }
}
