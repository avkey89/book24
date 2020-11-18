<?php

declare(strict_types=1);

namespace App\Transaction\ReadModel;

use App\Repository\BalanceRepository;

class UserBalance
{
    private BalanceRepository $balanceRepository;

    public function __construct(BalanceRepository $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function findByUser($user)
    {
        return $this->balanceRepository->findOneBy(["user"=>$user]);
    }
}