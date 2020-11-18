<?php

declare(strict_types=1);

namespace App\Transaction\Services;


use App\Entity\Balance;
use App\Transaction\ReadModel\UserBalance;
use Symfony\Component\HttpFoundation\Response;

class CheckBalance
{
    private UserBalance $userBalance;

    public function __construct(UserBalance $userBalance)
    {
        $this->userBalance = $userBalance;
    }

    public function check($user, int $amount)
    {
        $balance = $this->userBalance->findByUser($user);
        if ($balance->getBalance() < $amount) {
            throw new \DomainException("Insufficient funds to transfer", Response::HTTP_BAD_REQUEST);
        }

        return true;
    }
}