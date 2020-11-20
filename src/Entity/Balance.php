<?php

namespace App\Entity;

use App\Repository\BalanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BalanceRepository::class)
 */
class Balance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $balance;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="balance", cascade={"persist", "remove"})
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="debitBalance", orphanRemoval=true)
     */
    private $debitTransaction;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="creditBalance", orphanRemoval=true)
     */
    private $creditTransaction;

    public function __construct(int $balance, User $user)
    {
        $this->balance = $balance;
        $this->user = $user;
        $this->debitTransaction = new ArrayCollection();
        $this->creditTransaction = new ArrayCollection();
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
