<?php

namespace App\Form;

use App\Entity\Maintenancerecord;
use App\Entity\Equipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MaintenanceRecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipment', EntityType::class, [
                'class' => Equipment::class,
                'choice_label' => 'name',
                'label' => 'Équipement',
                'attr' => ['class' => 'form-control']
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'empty_data' => null,
                'invalid_message' => 'La date doit être valide.'
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Operational' => 'Operational',
                    'Needs Repair' => 'Needs Repair',
                    'Out of Service' => 'Out of Service'
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Statut'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maintenancerecord::class,
        ]);
    }
}