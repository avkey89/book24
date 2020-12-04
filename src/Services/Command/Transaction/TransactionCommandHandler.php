<?php

declare(strict_types=1);

namespace App\Services\Command\Transaction;

use App\Entity\Balance;
use App\Entity\Transaction;
use App\Repository\BalanceRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Services\Command\AbstractCommandHandler;
use App\Services\Command\CommandInterface;
use App\Services\Command\Transaction\Form\TransactionForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

class TransactionCommandHandler extends AbstractCommandHandler
{
    private UserRepository $userRepository;
    private BalanceRepository $balanceRepository;
    private TransactionRepository $transactionRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository $userRepository,
        BalanceRepository $balanceRepository,
        TransactionRepository $transactionRepository,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory)
    {
        parent::__construct($formFactory);
        $this->userRepository = $userRepository;
        $this->balanceRepository = $balanceRepository;
        $this->transactionRepository = $transactionRepository;
        $this->entityManager = $entityManager;
    }

    protected function dataTransferObject(): CommandInterface
    {
        return new TransactionCommand();
    }

    protected function dataTransformer(): string
    {
        return TransactionForm::class;
    }

    protected function execute(CommandInterface $commandData)
    {
        /** @var TransactionCommand $data */
        $data = $commandData;

        if (!$userFrom = $this->userRepository->findByEmail($data->from_user)) {
            throw new \DomainException("User '" . $data->from_user . "' not found.", Response::HTTP_NOT_FOUND);
        }
        if (!$userTo = $this->userRepository->findByEmail($data->to_user)) {
            throw new \DomainException("User '" . $data->to_user . "' not found.", Response::HTTP_NOT_FOUND);
        }

        $balanceUserFrom = $this->balanceRepository->findOneBy(["user"=>$userFrom]);
        $balanceUserTo = $this->balanceRepository->findOneBy(["user"=>$userTo]);

        if(!Balance::negativeBalanceCheck($balanceUserFrom->getBalance(), $data->amount)) {
            throw new \DomainException("Insufficient funds to transfer", Response::HTTP_BAD_REQUEST);
        }

        $transaction = new Transaction($balanceUserFrom, $balanceUserTo, $data->amount);

        $this->entityManager->beginTransaction();
        try {
            $balanceUserFrom->minusBalance($data->amount);
            $balanceUserTo->plusBalance($data->amount);
            $this->entityManager->persist($transaction);
            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new \RuntimeException($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}