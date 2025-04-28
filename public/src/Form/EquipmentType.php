<?php

namespace App\Form;

use App\Entity\Equipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Disponible' => Equipment::STATUS_AVAILABLE,
                    'Réservé' => Equipment::STATUS_RESERVED,
                    'Rupture de stock' => Equipment::STATUS_OUT_OF_STOCK,
                ],
                'placeholder' => 'Choisissez un statut',
            ])
            ->add('quantity')
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => 3],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
