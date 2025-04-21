<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
        
            ->add('totalprice', NumberType::class, [
                'label' => 'Prix total (DT)',
                'required' => true,
                'attr' => ['min' => 1],
                'scale' => 2,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut de la réservation',
                'choices' => [
                    'En attente' => 'en attente',
                    'Confirmée' => 'confirmée',
                    'Annulée' => 'annulée',
                ],
                'placeholder' => 'Choisir un statut',
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
       