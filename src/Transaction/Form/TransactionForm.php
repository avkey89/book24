<?php

declare(strict_types=1);

namespace App\Transaction\Form;

use App\Transaction\Request\TransactionFormRequest;
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
                'data_class' => TransactionFormRequest::class
            ]
        );
    }
}