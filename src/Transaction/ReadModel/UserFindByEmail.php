<?php

declare(strict_types=1);

namespace App\Transaction\ReadModel;

use App\Repository\UserRepository;

class UserFindByEmail
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function find($email)
    {
        return $this->userRepository->findByEmail($email);
    }
}