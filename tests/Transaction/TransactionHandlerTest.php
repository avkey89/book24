<?php

namespace App\Tests\Transaction;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionHandlerTest extends KernelTestCase
{
    private $client;

    public function setUp(): void
    {
        self::bootKernel();
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testTransactionImplementationInsufficient(): void
    {
        $data = [
            "amount" => 10000000,
            "from_user" => "useremail0@test.ru",
            "to_user" => "useremail1@test.ru"
        ];

        $response = $this->client->post('/transaction', [
            'body' => json_encode($data),
            'http_errors' => false
        ]);

        $message = json_decode($response->getBody(true), true);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("Insufficient funds to transfer", $message["message"]);
    }

    public function testTransactionImplementationUserNotFound(): void
    {
        $data = [
            "amount" => 10,
            "from_user" => "sdfsdfsdf@test.ru",
            "to_user" => "useremail1@test.ru"
        ];

        $response = $this->client->post('/transaction', [
            'body' => json_encode($data),
            'http_errors' => false
        ]);

        $message = json_decode($response->getBody(true), true);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("User '" . $data["from_user"] . "' not found.", $message["message"]);
    }

    public function testTransactionImplementationSuccess(): void
    {
        $data = [
            "amount" => 10,
            "from_user" => "useremail3@test.ru",
            "to_user" => "useremail4@test.ru"
        ];

        $response = $this->client->post('/transaction', [
            'body' => json_encode($data),
            'http_errors' => false
        ]);

        $message = json_decode($response->getBody(true), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals("Transaction successfully created", $message["message"]);
    }
}
