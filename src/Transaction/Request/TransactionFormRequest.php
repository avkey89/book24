<?php

declare(strict_types=1);

namespace App\Transaction\Request;

use App\Transaction\Dto\TransactionFormDto;
use Symfony\Component\Validator\Constraints as Assert;

class TransactionFormRequest
{
    /**
     * @var string
     * @Assert\NotBlank(message="11")
     * @Assert\Email()
     */
    public string $from_user;

    /**
     * @var string
     * @Assert\NotBlank(message="22")
     * @Assert\Email()
     */
    public string $to_user;

    /**
     * @var int
     * @Assert\NotBlank(message="333")
     * @Assert\Type("integer", message="444")
     * @Assert\Range(
     *     min = 0,
     *     minMessage="Negative translations are prohibited"
     * )
     */
    public int $amount;
}