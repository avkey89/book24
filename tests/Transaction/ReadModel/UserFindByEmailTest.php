<?php

namespace App\Tests\Transaction\ReadModel;

use App\Transaction\ReadModel\UserFindByEmail;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserFindByEmailTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testFindUserByEmailException()
    {
        $service = self::$container->get(UserFindByEmail::class);

        $this->expectException(\DomainException::class);

        $service->find("sawldkfjdflkgj@sdlkjf.ru");
    }
}
