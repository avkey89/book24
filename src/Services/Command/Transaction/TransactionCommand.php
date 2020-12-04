<?php

declare(strict_types=1);

namespace App\Services\Command\Transaction;

use App\Services\Command\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TransactionCommand implements CommandInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $from_user;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $to_user;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Assert\Range(
     *     min = 0,
     *     minMessage="Negative translations are prohibited"
     * )
     */
    public int $amount;
}