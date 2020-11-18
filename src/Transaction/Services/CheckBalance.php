<?php

declare(strict_types=1);

namespace App\Transaction\Services;

use Symfony\Component\HttpFoundation\Response;

class CheckBalance
{
    public function check(int $balance, int $amount)
    {
        if ($balance < $amount) {
            throw new \DomainException("Insufficient funds to transfer", Response::HTTP_BAD_REQUEST);
        }

        return true;
    }
}