<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class Reservation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ticketType', ChoiceType::class, [
                'label' => 'Type de billet',
                'choices' => [
                    'VIP' => 'VIP',
                    'BASIC' => 'BASIC',
                    'KID' => 'KID',
                ],
                'required' => true,
                'mapped' => false,
            ])
            ->add('ticketCount', IntegerType::class, [
                'label' => 'Nombre de billets',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nombre de billets est requis.']),
                    new Assert\Positive(['message' => 'Le nombre de billets doit être supérieur à zéro.']),
                ],
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])
            ->add('totalPrice', NumberType::class, [
                'label' => 'Prix total',
                'scale' => 2,
                'mapped' => false,
                'attr' => [
                    'readonly' => true,
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => 'en attente',
                    'Confirmee' => 'confirmee',
                    'Annulee' => 'annulee',
                ],
                'mapped' => true,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}


