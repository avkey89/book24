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
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $balance;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="balance", cascade={"persist", "remove"})
     */
    private ?User $user;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="debitBalance", orphanRemoval=true)
     */
    private $debitTransaction;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="creditBalance", orphanRemoval=true)
     */
    private $creditTransaction;

    public function __construct()
    {
        $this->debitTransaction = new ArrayCollection();
        $this->creditTransaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection|Transaction|null
     */
    public function getDebitTransaction(): Collection
    {
        return $this->debitTransaction;
    }

    public function addDebitTransaction(Transaction $debitTransaction): self
    {
        if (!$this->debitTransaction->contains($debitTransaction)) {
            $this->debitTransaction[] = $debitTransaction;
            $debitTransaction->setDebitBalance($this);
        }

        return $this;
    }

    public function removeDebitTransaction(Transaction $debitTransaction): self
    {
        if ($this->debitTransaction->contains($debitTransaction)) {
            $this->debitTransaction->removeElement($debitTransaction);
            if ($debitTransaction->getDebitBalance() === $this) {
                $debitTransaction->setDebitBalance(null);
            }
        }

        return $this;
    }

    /**
     * @param $debitTransaction
     * @return $this
     */
    public function setDebitTransaction($debitTransaction): self
    {
        $this->debitTransaction = $debitTransaction;

        return $this;
    }

    /**
     * @return Collection|Transaction|null
     */
    public function getCreditTransaction(): Collection
    {
        return $this->creditTransaction;
    }

    /**
     * @param $creditTransaction
     * @return $this
     */
    public function setCreditTransaction($creditTransaction): self
    {
        $this->creditTransaction = $creditTransaction;

        return $this;
    }

    public function addCreditTransaction(Transaction $creditTransaction): self
    {
        if (!$this->creditTransaction->contains($creditTransaction)) {
            $this->creditTransaction[] = $creditTransaction;
            $creditTransaction->setCreditAccount($this);
        }

        return $this;
    }

    public function removeCreditTransaction(Transaction $creditTransaction): self
    {
        if ($this->creditTransaction->contains($creditTransaction)) {
            $this->creditTransaction->removeElement($creditTransaction);
            // set the owning side to null (unless already changed)
            if ($creditTransaction->getCreditAccount() === $this) {
                $creditTransaction->setCreditAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
