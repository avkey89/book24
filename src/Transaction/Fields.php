<?php

declare(strict_types=1);

namespace App\Transaction;

use Symfony\Component\Validator\Constraints as Assert;

class Fields
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