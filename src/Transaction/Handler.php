<?php

declare(strict_types=1);

namespace App\Transaction;

use App\Entity\Transaction;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\JsonDecoder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class Handler
{

    private object $userRepository;
    private object $entityManager;
    private object $formFactory;
    private object $requestStack;
    private object $checkBalance;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        RequestStack $requestStack,
        CheckBalance $checkBalance)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
        $this->checkBalance = $checkBalance;
    }

    public function execution(): JsonResponse
    {
        try {
            $decoder = new JsonDecoder();
            $form = $this->formFactory->create(Form::class, new Fields());
            $data = $decoder->decode($this->requestStack->getCurrentRequest()->getContent());
            $form->submit($data);
            if ($form->isValid()) {
                $userFrom = $this->userRepository->findByEmail($form->getData()->from_user);
                $userTo = $this->userRepository->findByEmail($form->getData()->to_user);
                $this->checkBalance->check($userFrom, $form->getData()->amount);

                return $this->implementation($userFrom->getBalance(), $userTo->getBalance(), $form->getData()->amount);
            } else {
                return new JsonResponse(["message" => (string)$form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return new JsonResponse(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function implementation($userFromBalance, $userToBalance, $amount): JsonResponse
    {
        $transaction = new Transaction($userFromBalance, $userToBalance, $amount);

        $this->entityManager->beginTransaction();
        try {
            $userFromBalance->setBalance($userFromBalance->getBalance() - $amount);
            $userFromBalance->setBalance($userFromBalance->getBalance() + $amount);

            $this->entityManager->persist($transaction);
            $this->entityManager->flush();
            $this->entityManager->commit();

            return new JsonResponse(["message" => "Transaction successfully created"], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            return new JsonResponse(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}