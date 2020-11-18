<?php

declare(strict_types=1);

namespace App\Transaction;

use App\Transaction\ReadModel\UserBalance;
use App\Transaction\ReadModel\UserFindByEmail;
use App\Transaction\Services\CheckBalance;
use App\Transaction\WriteModel\TransactionSave;
use Symfony\Component\HttpFoundation\JsonResponse;

class TransactionHandler
{
    private object $checkBalance;
    private object $userFindByEmail;
    private object $transactionSave;
    private object $userBalance;

    public function __construct(
        CheckBalance $checkBalance,
        UserFindByEmail $userFindByEmail,
        TransactionSave $transactionSave,
        UserBalance $userBalance)
    {
        $this->checkBalance = $checkBalance;
        $this->userFindByEmail = $userFindByEmail;
        $this->transactionSave = $transactionSave;
        $this->userBalance = $userBalance;
    }

    public function execution($fromUser, $toUser, $amount): JsonResponse
    {
        $userFrom = $this->userFindByEmail->find($fromUser);
        $userTo = $this->userFindByEmail->find($toUser);

        $balanceUserFrom = $this->userBalance->findByUser($userFrom);
        $balanceUserTo = $this->userBalance->findByUser($userTo);

        $this->checkBalance->check($balanceUserFrom->getBalance(), $amount);

        return $this->transactionSave->implementation($balanceUserFrom, $balanceUserTo, $amount);
    }
}