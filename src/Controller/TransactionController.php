<?php

namespace App\Controller;

use App\Transaction\Form\TransactionForm;
use App\Transaction\Request\TransactionFormRequest;
use App\Transaction\TransactionHandler;

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
    public function transaction(Request $request, TransactionHandler $transactionHandler): JsonResponse
    {
        try {
            $transactionRequest = new TransactionFormRequest();
            $form = $this->createForm(TransactionForm::class, $transactionRequest);
            $form->submit($request->request->all());

            if ($form->isValid()) {
                return $transactionHandler->execution($transactionRequest->from_user, $transactionRequest->to_user, $transactionRequest->amount);
            } else {
                return $this->json(["message" => (string)$form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
