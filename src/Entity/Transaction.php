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
    private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $date;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Balance::class, inversedBy="debitTransaction")
     */
    private ?Balance $debitBalance;

    /**
     * @ORM\ManyToOne(targetEntity=Balance::class, inversedBy="creditTransaction")
     */
    private ?Balance $creditBalance;

    public function __construct(Balance $debitBalance, Balance $creditBalance, int $amount)
    {
        $this->debitBalance = $debitBalance;
        $this->creditBalance = $creditBalance;
        $this->amount = $amount;
        $this->date = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Balance|null
     */
    public function getDebitBalance(): ?Balance
    {
        return $this->debitBalance;
    }

    /**
     * @param Balance|null $debitBalance
     */
    public function setDebitBalance(?Balance $debitBalance): void
    {
        $this->debitBalance = $debitBalance;
    }

    /**
     * @return Balance|null
     */
    public function getCreditBalance(): ?Balance
    {
        return $this->creditBalance;
    }

    /**
     * @param Balance|null $creditBalance
     */
    public function setCreditBalance(?Balance $creditBalance): void
    {
        $this->creditBalance = $creditBalance;
    }



}
