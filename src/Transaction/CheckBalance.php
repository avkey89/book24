<?php

declare(strict_types=1);

namespace App\Transaction;


class CheckBalance
{
    public function check($userFrom, int $amount)
    {
        if ($userFrom->getBalance()->getBalance() < $amount) {
            throw new \DomainException("Insufficient funds to transfer");
        }

        return true;
    }
}