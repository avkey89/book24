<?php

namespace App\Tests\Transaction;

use App\Transaction\TransactionHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionHandlerTest extends KernelTestCase
{
    protected $entityManager;

    protected function setUp(): void
    {
        parent::bootKernel();

        $this->entityManager = self::$container
            ->get('doctrine')
            ->getManager();

        $this->entityManager->getConnection()->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->entityManager->getConnection()->rollBack();
        $this->entityManager->close();
        $this->entityManager = null;
        parent::tearDown();
    }

    public function testHandlerSuccess()
    {
        $transaction = self::$container
            ->get(TransactionHandler::class);

        $transaction->handler("useremail1@test.ru", "useremail2@test.ru", 50);

        $this->assertJson("{\"message\": \"Transaction successfully created\"}");
    }

    public function testHandlerFalse()
    {
        $transaction = self::$container
            ->get(TransactionHandler::class);

        $this->expectException(\DomainException::class);

        $transaction->handler("useremail1@test.ru", "useremail2@test.ru", 80000000);
    }
}
