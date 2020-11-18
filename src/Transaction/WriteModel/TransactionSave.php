<?php

declare(strict_types=1);

namespace App\Transaction\WriteModel;

use App\Entity\Transaction;
use App\Transaction\ReadModel\UserBalance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TransactionSave
{
    private EntityManagerInterface $entityManager;
    private UserBalance $userBalance;

    public function __construct(EntityManagerInterface $entityManager, UserBalance $userBalance)
    {
        $this->entityManager = $entityManager;
        $this->userBalance = $userBalance;
    }

    public function implementation($userFrom, $userTo, $amount)
    {
        $transaction = new Transaction($userFrom, $userTo, $amount);

        $this->entityManager->beginTransaction();
        try {
            $this->entityManager->persist($transaction);
            $this->entityManager->flush();
            $this->entityManager->commit();

            return new JsonResponse(["message" => "Transaction successfully created"], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            return new JsonResponse(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}