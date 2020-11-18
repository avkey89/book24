<?php

declare(strict_types=1);

namespace App\Transaction\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionFormDto
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $from_user;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $to_user;

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Assert\Range(
     *     min = 0,
     *     minMessage="Negative translations are prohibited"
     * )
     */
    public int $amount;
}