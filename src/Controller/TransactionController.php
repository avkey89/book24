<?php

namespace App\Controller;

use App\Services\Command\Transaction\TransactionCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction", methods={"POST"}, name="transaction")
     */
    public function transaction(Request $request, TransactionCommandHandler $transactionCommandHandler): JsonResponse
    {
        try {
            $transactionCommandHandler->handler($request->request->all());

            return new JsonResponse(["message" => "Transaction successfully created"], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(["success"=>false, "message" => $e->getMessage()], $e->getCode());
        }
    }
}
