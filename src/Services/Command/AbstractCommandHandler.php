<?php

declare(strict_types=1);

namespace App\Services\Command;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractCommandHandler implements CommandHandlerInterface
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function handler(array $request): bool
    {
        $dataTransferObject = $this->dataTransferObject();
        $form = $this->formFactory->create($this->dataTransformer(), $dataTransferObject);
        $form->submit($request);
        if ($form->isValid()) {
            $this->execute($dataTransferObject);
        } else {
            $errors = '';
            foreach($form->getErrors(true) as $error) {
                $errors .= $error->getMessage() . "\n";
            }
            throw new \DomainException($errors, Response::HTTP_BAD_REQUEST);
        }

        return true;
    }

    abstract protected function dataTransferObject(): CommandInterface;

    abstract protected function dataTransformer(): string;

    abstract protected function execute(CommandInterface $commandData);
}