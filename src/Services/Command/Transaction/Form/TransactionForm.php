<?php

declare(strict_types=1);

namespace App\Services\Command\Transaction\Form;

use App\Services\Command\Transaction\TransactionCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('from_user', TextType::class)
            ->add('to_user', TextType::class)
            ->add('amount', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => TransactionCommand::class
            ]
        );
    }
}