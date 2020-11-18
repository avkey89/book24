<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $date;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Balance::class, inversedBy="debitTransaction")
     */
    private Balance $debitBalance;

    /**
     * @ORM\ManyToOne(targetEntity=Balance::class, inversedBy="creditTransaction")
     */
    private Balance $creditBalance;

    public function __construct(Balance $debitBalance, Balance $creditBalance, int $amount)
    {
        $this->debitBalance = $debitBalance;
        $this->creditBalance = $creditBalance;
        $this->amount = $amount;
        $this->date = new \DateTime("now");
    }
}
