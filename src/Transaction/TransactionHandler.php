<?php

declare(strict_types=1);

namespace App\Transaction;

use App\Transaction\ReadModel\UserFindByEmail;
use App\Transaction\Services\CheckBalance;
use App\Transaction\WriteModel\TransactionSave;
use Symfony\Component\HttpFoundation\JsonResponse;

class TransactionHandler
{
    private object $checkBalance;
    private object $userFindByEmail;
    private object $transactionSave;

    public function __construct(
        CheckBalance $checkBalance,
        UserFindByEmail $userFindByEmail,
        TransactionSave $transactionSave)
    {
        $this->checkBalance = $checkBalance;
        $this->userFindByEmail = $userFindByEmail;
        $this->transactionSave = $transactionSave;
    }

    public function execution($fromUser, $toUser, $amount): JsonResponse
    {
        $userFrom = $this->userFindByEmail->find($fromUser);
        $userTo = $this->userFindByEmail->find($toUser);

        $this->checkBalance->check($userFrom, $amount);

        return $this->transactionSave->implementation($userFrom, $userTo, $amount);
    }
}