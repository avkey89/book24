<?php

namespace App\Tests\Transaction;

use App\Services\Command\Transaction\TransactionCommandHandler;
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

    public function testTransactionHandlerSuccess()
    {
        /** @var TransactionCommandHandler $transaction */
        $transaction = self::$container
            ->get(TransactionCommandHandler::class);

        $response = $transaction->handler(["from_user"=>"useremail1@test.ru", "to_user"=>"useremail2@test.ru", "amount"=>50]);

        $this->assertJson("{\"message\": \"Transaction successfully created\"}");
        $this->assertTrue($response);
    }

    public function testTransactionHandlerFalse()
    {
        /** @var TransactionCommandHandler $transaction */
        $transaction = self::$container
            ->get(TransactionCommandHandler::class);

        $this->expectException(\DomainException::class);
        $this->expectExceptionCode(400);

        $transaction->handler(["from_user"=>"useremail1@test.ru", "to_user"=>"useremail2@test.ru", "amount"=>50000000000000]);
    }
}
