<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Balance;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private array $users;

    public function __construct()
    {
        for($i = 0; $i < 10; $i++) {
            $this->users[] = [
                'name' => 'New User ' . $i,
                'email' => 'useremail' . $i . '@test.ru',
                'balance' => 1000
            ];
        }
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->users as $userData) {
            $user = new User($userData['name'], $userData['email']);
            $balance = new Balance();

            $balance
                ->setUser($user)
                ->setBalance($userData['balance']);

            $user->setBalance($balance);

            $manager->persist($user);
        }
        $manager->flush();
    }
}