<?php

namespace App\Tests\Transaction\Services;

use App\Transaction\Services\CheckBalance;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckBalanceTest extends KernelTestCase
{
    private $check;

    public function setUp(): void
    {
        self::bootKernel();
        $this->check = new CheckBalance();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testCheckTrue()
    {
        $result = $this->check->check(100, 10);

        $this->assertTrue($result);
    }

    public function testCheckFalseException()
    {
        $this->expectException(\DomainException::class);

        $this->check->check(100, 10000);
    }

    public function testCheckFalseExceptionMessage()
    {
        $this->expectExceptionMessage("Insufficient funds to transfer");

        $this->check->check(100, 10000);
    }
}
