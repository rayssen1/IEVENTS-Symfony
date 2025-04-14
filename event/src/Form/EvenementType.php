<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Eventspeaker;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('dateEvent', null, [
                'widget' => 'single_text',
                'data' => (new \DateTime()), // Default to tomorrow
            ])
            ->add('lieu')
            ->add('nbPlace')
            ->add('prix')
            ->add('status')
            ->add('img')
            ->add('eventspeakerId', EntityType::class, [
                'class' => Eventspeaker::class,
                'choice_label' => function (Eventspeaker $speaker) {
                    return $speaker->getNom() . ' ' . $speaker->getPrenom(); // Display full name
                },
                'label' => 'Orateur',
                'placeholder' => 'Sélectionner un speaker', // Optional: empty option
                'required' => false, // Optional: allow no selection
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->andWhere('e.status = :status')
                        ->setParameter('status', 'dispo')
                        ->orderBy('e.nom', 'ASC');
                },
                'attr' => ['class' => 'form-select'], // Select box styling
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
